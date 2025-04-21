export type Office = {
    id: number
    name: string
    description: string
    code: string
    deleted_at?: string
    updated_at?: string
    created_at?: string
}

export type Section = {
    id: number
    title: string
    description: string
    office_id: number
    parent_id: number
    slug: string
    deleted_at?: string
    updated_at?: string
    created_at?: string
}

export type Documents = {
    id: string
    section_id: number
    contents: string
    deleted_at?: string
    updated_at?: string
    created_at?: string
}
