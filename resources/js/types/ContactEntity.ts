export interface ContactEntity {
    id?: number;
    name: string;
    email: string;
    phone: string;
    notes?: string | null;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
}
