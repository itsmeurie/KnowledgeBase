export type Office = {
  id: number;
  name: string;
  description: string;
  code: string;
  deleted_at?: string;
  updated_at?: string;
  created_at?: string;
};

export type UploadedFile = {
  id?: number;
  name: string;
  mime: string;
  size: number;
  ext: string;
  fileable_id: number;
  fileable_type: string;
  deleted_at?: string;
  updated_at?: string;
  created_at?: string;
  prevUrl: string;
  downUrl: string;
};

export type Section = {
  id: number;
  title: string;
  description: string;
  office_id: number;
  parent_id: number;
  contents: string;
  slug: string;
  deleted_at?: string;
  updated_at?: string;
  created_at?: string;
  subsections?: Section[];
  files?: Array<UploadedFile>;
  active?: boolean;
};

export type Documents = {
  id: string;
  section_id: number;
  contents: string;
  deleted_at?: string;
  updated_at?: string;
  created_at?: string;
};
