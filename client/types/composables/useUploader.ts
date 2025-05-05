import type { HasKey, Prettify } from "~/types";

export type UploadOptionsSleep = Prettify<
  HasKey & {
    long: number;
    short: number;
    interval: number;
  }
>;

export type UploadOptions = Prettify<
  HasKey & {
    api: string;
    checkIntegrity?: boolean;
    multiple?: boolean;

    sleep?: UploadOptionsSleep;
  }
>;

export type FileItemState = Prettify<
  HasKey & {
    uid: string;
    part: number;
    parts: number;
    length: number;
    progress: number;
  }
>;

export type FileItemUpload = Prettify<
  HasKey & {
    timer: NodeJS.Timeout | null;
    speed: number;
    start: number;
    ellapsed: number;
    loaded: number;
    timeRemaining: number;
    progress: number;
  }
>;

export type FileItem = Prettify<
  HasKey & {
    id: string;
    file: File;
    name: string;
    status: "pending" | "uploading" | "complete" | "error" | "cancelled";
    state?: FileItemState;
    upload: FileItemUpload;
    remove: (force: boolean) => void;
    matchedHash?: boolean;
    hashing: boolean;
  }
>;
