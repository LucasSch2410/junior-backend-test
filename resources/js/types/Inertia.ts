import { ContactEntity } from "./ContactEntity";

export interface Link {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginatedContacts {
    data: ContactEntity[];
    links: Link[];
    page: number;
    last_page_url: string;
    last_page: number;
    from: number;
    first_page_url: string;
    current_page: number;
    next_page_url: string;
    path: string;
    per_page: number;
    to: number;
    total: number
}

export interface PageProps {
    [key: string]: any;
    contacts: PaginatedContacts;
    flash?: {
        success?: string;
        error?: string;
    };
}
