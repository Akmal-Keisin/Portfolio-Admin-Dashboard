export interface Message {
    id: number;
    name: string;
    email: string;
    subject: string;
    message: string;
    status: 'inbox' | 'archived';
    isRead: boolean;
    isImportant: boolean;
    createdAt: string;
    updatedAt: string;
    diffForHumans: string;
}
