export interface RootState {
}

export interface User {
    id: number;
    name: string;
    username: string;
    user_type: 'admin' | 'user';
}

export interface Comment {
    id: number;
    user: User;
    content: string;
    created_at: string;
}
