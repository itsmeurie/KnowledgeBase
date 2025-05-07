<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\VerificationController;

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LogController;

use App\Http\Controllers\GenderController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\DocumentsController;
use App\Models\Section;

Route::middleware(["auth:web,sanctum", "throttle:90,1", "isActive"])->group(function () {
    Route::middleware(["verified", "SPAOnly"])->group(function () {
        #region Permissions Management
        Route::prefix("permissions")->group(function () {
            Route::get("", [PermissionsController::class, "list"])->name("permissions.list");
            Route::post("", [PermissionsController::class, "store"])->name("permissions.store");
            Route::patch("{permission}", [PermissionsController::class, "update"])->name("permissions.update");
            Route::delete("{permission}", [PermissionsController::class, "destroy"])->name("permissions.destroy");
        });
        #endregion

        #region Roles Management
        Route::prefix("roles")->group(function () {
            Route::get("", [RolesController::class, "list"])->name("roles.list");
            Route::get("permissions", [RolesController::class, "getPermissions"])->name("roles.get_permissions");
            Route::post("", [RolesController::class, "store"])->name("roles.store");
            Route::patch("{role}", [RolesController::class, "update"])->name("roles.update");
            Route::delete("{role}", [RolesController::class, "destroy"])->name("roles.destroy");
        });
        #endregion

        #region Users Management
        Route::get("/users", [UsersController::class, "getUsers"]);
        Route::prefix("user")->group(function () {
            Route::get("roles", [UsersController::class, "getRoles"]);
            Route::get("genders", [UsersController::class, "getGenders"])->name("users.genders");
            Route::post("", [UsersController::class, "addUser"]);

            Route::put("team/{user}", [UsersController::class, "changeTeam"])->name("users.team.switch");

            Route::patch("profile/{user}", [UsersController::class, "updateProfile"])->name("users.profile.update");
            Route::patch("username/{user}", [UsersController::class, "updateUsername"])->name("users.username.update");
            Route::patch("email/{user}", [UsersController::class, "updateEmail"])->name("users.email.update");
            Route::patch("verify/{user}", [UsersController::class, "verifyEmail"])->name("users.email.verify");
            Route::patch("password/{user}", [UsersController::class, "updatePassword"])->name("users.password.update");
            Route::delete("toggle/{user}", [UsersController::class, "toggleUser"]);

            Route::prefix("permissions")->group(function () {
                Route::get("", [UsersController::class, "getPermissions"]);
                Route::patch("{user}", [UsersController::class, "updatePermissions"]);
            });

            Route::patch("address-primary/{user}/{address}", [UsersController::class, "setMainAddress"])->name("users.address.primary");
            Route::prefix("address")->group(function () {
                Route::post("{user}", [UsersController::class, "addAddress"])->name("users.address.create");
                Route::patch("{user}/{address}", [UsersController::class, "updateAddress"])->name("users.address.update");
                Route::delete("{user}/{address}", [UsersController::class, "deleteAddress"])->name("users.address.delete");
            });

            Route::prefix("avatar")->group(function () {
                Route::post("{user}", [UsersController::class, "addAvatar"]);
                Route::patch("{user}/{image}", [UsersController::class, "changeAvatar"]);
                Route::delete("{user}/{image}", [UsersController::class, "deleteAvatar"]);
            });
        });
        #endregion

        #region Profile
        Route::prefix("auth")->group(function () {
            Route::get("profile", [AuthenticationController::class, "getPermissions"])->name("auth.profile.show");
            Route::patch("email", [ProfileController::class, "updateEmail"])->name("auth.email.update");
            Route::patch("username", [ProfileController::class, "updateUsername"])->name("auth.username.update");
            Route::patch("password", [ProfileController::class, "updatePassword"])->name("auth.password.update");
            Route::patch("profile", [ProfileController::class, "updateProfile"])->name("auth.profile.update");

            Route::patch("address-primary/{address}", [ProfileController::class, "setMainAddress"])->name("auth.address.primary");
            Route::prefix("address")->group(function () {
                // Route::get("", [ProfileController::class, "getAddresses"])->name("auth.address.list");
                Route::post("", [ProfileController::class, "addAddress"])->name("auth.address.create");
                Route::patch("{address}", [ProfileController::class, "updateAddress"])->name("auth.address.update");
                Route::delete("{address}", [ProfileController::class, "deleteAddress"])->name("auth.address.delete");
            });

            Route::prefix("avatars")->group(function () {
                // Route::get("", [ProfileController::class, "getAvatars"])->name("auth.avatars.list");
                Route::post("", [ProfileController::class, "addAvatar"])->name("auth.avatars.create");
                Route::patch("{image}", [ProfileController::class, "changeAvatar"])->name("auth.avatars.update");
                Route::delete("{image}", [ProfileController::class, "deleteAvatar"])->name("auth.avatars.delete");
            });
        });
        #endregion

        #region Logs
        Route::get("/logsy/{year}/{month?}/{day?}", [LogController::class, "getLogs"]);
        Route::get("/log/setup", [LogController::class, "getLogSetup"]);
        Route::get("/log/files", [LogController::class, "getLogFiles"]);
        Route::get("/log/system/{name}", [LogController::class, "getSystemLog"]);
        Route::get("/log/download", [LogController::class, "downloadLogFiles"]);
        Route::delete("/log/system", [LogController::class, "deleteLogFiles"]);
        #endregion

        Route::get("/img/pri/{image}/{size?}", [ImageController::class, "imageDisplay"])->name("image.display.private");

        Route::prefix("offices")->group(function () {
            Route::get("", [OfficeController::class, "list"])->name("offices.list");
            Route::get("{office}", [OfficeController::class, "show"])->name("offices.show");
            Route::post("", [OfficeController::class, "create"])->name("offices.create");
            Route::put("{office}", [OfficeController::class, "update"])->name("offices.update");
            Route::delete("{office}", [OfficeController::class, "delete"])->name("offices.delete");
            Route::patch("{office}", [OfficeController::class, "restore"])->name("offices.restore");
        });

        Route::prefix("sections")->group(function () {
            Route::get("office/{parent_id?}", [SectionController::class, "list"])->name("sections.list");
            Route::get("slug/{slug}", [SectionController::class, "show"])->name("sections.show");
            Route::get("section/{parent_id?}", [SectionController::class, "getSectionByParentId"])->name("sections.getSectionByParentId");
            Route::get("/files/{slug}", [SectionController::class, "getFiles"]);
            Route::get("/download/{file}", [SectionController::class, "download"])->name("section.download");
            Route::get("preview/{file}", [SectionController::class, "preview"])->name("section.preview");

            Route::post("", [SectionController::class, "create"])->name("sections.create");
            Route::put("{section}", [SectionController::class, "update"])->name("sections.update");
            Route::delete("delete/{section}", [SectionController::class, "delete"])->name("sections.delete");
            Route::patch("{restore/section}", [SectionController::class, "restore"])->name("sections.restore");
            Route::post("file/upload/{section}", [SectionController::class, "upload"])->name("sections.upload");
        });
    });

    Route::prefix("auth")->group(function () {
        Route::patch("profile-update", [ProfileController::class, "updateProfile"])->name("auth.profile.update.forced");
        Route::post("logout", [AuthenticationController::class, "logout"]);
        Route::get("permissions", [AuthenticationController::class, "getPermissions"])->name("auth.permissions");
        Route::get("teams", [AuthenticationController::class, "getTeams"])->name("auth.teams");
        route::put("team", [AuthenticationController::class, "switchTeam"])->name("auth.team.switch");

        Route::prefix("email")->group(function () {
            route::post("resend", [VerificationController::class, "resend"]);
            Route::get("verify/{id}/{hash}", [VerificationController::class, "verify"])->name("verification.verify");
        });
    });
});

/**
 * Unthrottled private routes
 */
Route::middleware(["auth:web,sanctum"])->group(function () {
    Route::middleware(["verified", "SPAOnly"])->group(function () {});
});
/**
 * Public routes
 */
Route::middleware(["api", "throttle:60,1"])->group(function () {
    Route::prefix("auth")->group(function () {
        Route::post("login", [AuthenticationController::class, "loginSpa"])
            ->name("auth.login")
            ->middleware(["SPAOnly"]);
    });

    Route::prefix("password")->group(function () {
        Route::post("forgot", [PasswordController::class, "forgot_password"])->name("password.email");
        Route::post("reset", [PasswordController::class, "reset_password"])->name("password.update");
    });

    #region Address
    Route::prefix("address")->group(function () {
        Route::get("initial/barangay/{code}", [AddressController::class, "getBarangayAddress"]);
        Route::get("initial/city/{code}", [AddressController::class, "getCityAddress"]);
        Route::get("regions", [AddressController::class, "Regions"]);
        Route::get("provinces/{regionCode}", [AddressController::class, "Provinces"]);
        Route::get("cities/{provinceCode}", [AddressController::class, "Cities"]);
        Route::get("barangays/{cityCode}", [AddressController::class, "Barangays"]);
        Route::get("types", [AddressController::class, "getAddressTypes"]);
    });
    #endregion

    Route::post("give-me-data", function (Request $request) {
        $validated_data = Validator::make($request->all(), ["price" => "required|decimal:0,99999.99", "message" => "nullable"]);
        dd($request->input(), $validated_data->validate());
    });

    Route::prefix("documents")->group(function () {
        Route::get("", [DocumentsController::class, "list"])->name("documents.list");
        Route::get("{document}", [DocumentsController::class, "show"])->name("documents.show");
        Route::post("", [DocumentsController::class, "create"])->name("documents.create");
        Route::put("{document}", [DocumentsController::class, "update"])->name("documents.update");
        Route::delete("{document}", [DocumentsController::class, "delete"])->name("documents.delete");
        Route::patch("{document}", [DocumentsController::class, "restore"])->name("documents.restore");
    });

    Route::prefix("genders")->group(function () {
        Route::get("", [GenderController::class, "list"])->name("genders.list");
    });
});

/**
 * Public Mobile Routes
 * prettier-ignore
 */
Route::middleware(["api", "throttle:60,1"])->prefix("v1.0")->group(function () {
    Route::post("gettoken", [AuthenticationController::class, "loginMobile"])->name("auth.login.mobile");
});

/**
 * Mobile Routes
 * prettier-ignore
 */
Route::middleware(["auth:web,sanctum", "throttle:60,1"])->prefix("v1.0")->group(function () {
    Route::middleware(["verified"])->group(function () {

    });
});
