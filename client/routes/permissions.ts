export const settings = {
  "settings-accounts": [
    "users_add",
    "users_list",
    "users_edit-profile",
    "users_edit-account",
    "users_edit-permission",
    "users_change-status",
  ],
  "settings-permissions": [],
  "settings-roles": ["roles_list", "roles_add", "roles_edit", "roles_delete"],
  "settings-logs": [],
  "system-sections": ["create_section", "delete_article", "restore_article"],
  "manage-articles": ["update_section", "upload_files", "delete_article"],
};

export const dasboard = {};

export default Object.assign({}, settings, dasboard);
