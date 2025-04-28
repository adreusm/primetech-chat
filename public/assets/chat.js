class Chat {
    constructor() {
        this.pollInterval = 1000;
        this.init();
    }
    
    init() {
        this.loadMessages();
        setInterval(() => this.loadMessages(), this.pollInterval);
        
        document.getElementById('send-btn').addEventListener('click', () => this.sendMessage());
        document.getElementById('message-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    }
    
    async loadMessages() {
        try {
            const response = await fetch('/api/messages');
            const messages = await response.json();
            this.renderMessages(messages);
        } catch (error) {
            console.error('Error loading messages:', error);
        }
    }
    
    async sendMessage() {
        const input = document.getElementById('message-input');
        const content = input.value.trim();
        
        if (!content) return;
        
        try {
            await fetch('/api/messages', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ content })
            });
            input.value = '';
        } catch (error) {
            console.error('Error sending message:', error);
        }
    }
    
    renderMessages(messages) {
        const container = document.getElementById('messages');
        container.innerHTML = messages.map(msg => {
            return(
            `<div class="message ${msg.role === 'admin' ? 'admin' : ''} ${msg.is_deleted ? 'deleted' : ''}" data-id="${msg.id}">
                <span class="username">${msg.username}:</span>
                <span class="content">${msg.content}</span>
                <span class="time">${new Date(msg.created_at).toLocaleTimeString()}</span>
                ${currentUser.isAdmin  ? 
                    `<button class="delete-btn" data-id="${msg.id}">delete</button>` : ''}
            </div>`);
        }).join('');
        
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.deleteMessage(e.target.dataset.id);
            });
        });
        
        container.scrollTop = container.scrollHeight;
    }
    
    async deleteMessage(id) {
        try {
            const response = await fetch(`/api/messages/${id}`, {
                method: 'DELETE'
            });
            
            const result = await response.json();
            if (result.status === 'success') {
                this.loadMessages();
            }
        } catch (error) {
            console.error('Error deleting message:', error);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => new Chat());