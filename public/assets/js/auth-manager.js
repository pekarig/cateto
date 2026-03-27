/**
 * Authentication Manager
 * Kezeli a bejelentkezést, kijelentkezést és a token tárolást
 */

class AuthManager {
    constructor() {
        this.API_URL = 'http://localhost:8000/api';
        this.authToken = localStorage.getItem('auth_token');
        this.user = null;
        
        // Auto-check auth status
        if (this.authToken) {
            this.loadUser();
        }
    }
    
    /**
     * Bejelentkezés
     */
    async login(email, password) {
        try {
            const response = await fetch(`${this.API_URL}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });
            
            if (!response.ok) {
                throw new Error('Hibás email vagy jelszó');
            }
            
            const data = await response.json();
            
            // Token tárolása
            this.authToken = data.token;
            localStorage.setItem('auth_token', data.token);
            
            // User adatok tárolása
            this.user = data.user;
            localStorage.setItem('user', JSON.stringify(data.user));
            
            console.log('✅ Sikeres bejelentkezés:', this.user);
            
            return data;
        } catch (error) {
            console.error('❌ Bejelentkezési hiba:', error);
            throw error;
        }
    }
    
    /**
     * Kijelentkezés
     */
    async logout() {
        try {
            // API hívás (ha van logout endpoint)
            if (this.authToken) {
                await fetch(`${this.API_URL}/auth/logout`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${this.authToken}`,
                        'Accept': 'application/json',
                    }
                });
            }
        } catch (error) {
            console.error('Logout hiba:', error);
        } finally {
            // Mindenképp töröljük a local storage-ot
            this.authToken = null;
            this.user = null;
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
            
            console.log('✅ Kijelentkezve');
        }
    }
    
    /**
     * User adatok betöltése
     */
    async loadUser() {
        try {
            // Először próbáljuk a localStorage-ból
            const cachedUser = localStorage.getItem('user');
            if (cachedUser) {
                this.user = JSON.parse(cachedUser);
            }
            
            // Majd frissítjük az API-ról (ha van user endpoint)
            // const response = await fetch(`${this.API_URL}/user`, {
            //     headers: {
            //         'Authorization': `Bearer ${this.authToken}`,
            //         'Accept': 'application/json',
            //     }
            // });
            // 
            // if (response.ok) {
            //     this.user = await response.json();
            //     localStorage.setItem('user', JSON.stringify(this.user));
            // }
        } catch (error) {
            console.error('User betöltési hiba:', error);
        }
    }
    
    /**
     * Be van-e jelentkezve?
     */
    isAuthenticated() {
        return !!this.authToken;
    }
    
    /**
     * Token getter
     */
    getToken() {
        return this.authToken;
    }
    
    /**
     * User getter
     */
    getUser() {
        return this.user;
    }
}

// Globális példány
window.authManager = new AuthManager();
