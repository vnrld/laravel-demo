# Laravel 8 demo

- Using Laravel Sail (https://laravel.com/docs/8.x/sail)

## Components

### Auth
- [auth configuration](config/auth.php)
#### Auth/Guards
- [DemoGuard](app/Auth/Guards/DemoGuard.php)
#### Auth/Providers
- [DemoUserProvider](app/Auth/Providers/DemoUserProvider.php)

### Console
#### Console/Commands
- [DateProviderCommand](app/Console/Commands/DateProviderCommand.php)
- [Kernel](app/Console/Kernel.php)

Scheduler daemon:
```shell
./vendor/bin/sail artisan schedule:work
```

### Contracts
- [CacheCrudRepositoryContract](app/Contracts/CacheCrudRepositoryContract.php)
- [CrudRepositoryContract](app/Contracts/CrudRepositoryContract.php)
- [ExceptionRendererContract](app/Contracts/ExceptionRendererContract.php)
- [UserHistoryRepositoryContract](app/Contracts/UserHistoryRepositoryContract.php)
- [UserRepositoryContract](app/Contracts/UserRepositoryContract.php)

### Exceptions
- [Handler](app/Exceptions/Handler.php)

#### Exceptions/Renderer

##### Exceptions/Renderer/Authentication
- [NotAuthenticatedRenderer](app/Exceptions/Renderer/Authentication/NotAuthenticatedRenderer.php)

##### Exceptions/Renderer/Validation
- [ValidationRenderer](app/Exceptions/Renderer/Validation/ValidationRenderer.php)

#### Exceptions/User
- [NotAuthenticatedException](app/Exceptions/User/NotAuthenticatedException.php)
- [NotFoundException](app/Exceptions/User/NotFoundException.php)

#### Exceptions/Validation
- [ApiValidationException](app/Exceptions/Validation/ApiValidationException.php)
- [AppValidationException](app/Exceptions/Validation/AppValidationException.php)
- [WebValidationException](app/Exceptions/Validation/WebValidationException.php)

### Http
#### Http/Controllers
##### Http/Controllers/Auth
- [CognitoController](app/Http/Controllers/CognitoController.php)
- [FileController](app/Http/Controllers/FileController.php)
- [UsersController](app/Http/Controllers/UsersController.php)

#### Http/Messaging
- [MessageCodes](app/Http/Messaging/MessageCodes.php)

#### Http/Middleware
- [ApiAuthenticate](app/Http/Middleware/ApiAuthenticate.php)

#### Http/Requests
- [BaseFormRequest](app/Http/Requests/BaseFormRequest.php)


##### Http/Requests/Cognito
- [ListUserPoolsRequest](app/Http/Requests/Cognito/ListUserPoolsRequest.php)

##### Http/Requests/File
- [FileRequest](app/Http/Requests/File/FileRequest.php)

##### Http/Requests/Route
- [RouteRequest](app/Http/Requests/Route/RouteRequest.php)

##### Http/Requests/User
- [CreateUserRequest](app/Http/Requests/User/CreateUserRequest.php)
- [DeleteUserRequest](app/Http/Requests/User/DeleteUserRequest.php)
- [ReadUserRequest](app/Http/Requests/User/ReadUserRequest.php)
- [UpdateUserRequest](app/Http/Requests/User/UpdateUserRequest.php)

##### Http/Requests/Validation
###### Http/Requests/Validation/Rules
###### Http/Requests/Validation/Rules/File
- [FileRequestDiskRule](app/Http/Requests/Validation/Rules/File/FileRequestDiskRule.php)

### Models
- [User](app/Models/User.php)
- [UserHistory](app/Models/UserHistory.php)

### Observers
- [UserObserver](app/Observers/UserObserver.php)

### Providers
- [AppServiceProvider](app/Providers/AppServiceProvider.php)
- [AuthServiceProvider](app/Providers/AuthServiceProvider.php)
- [RouteServiceProvider](app/Providers/RouteServiceProvider.php)

### Repositories
- [CacheRepository](app/Repositories/CacheRepository.php)
- [UserHistoryRepository](app/Repositories/UserHistoryRepository.php)
- [UserRepository](app/Repositories/UserRepository.php)

### Services
- [CognitoService](app/Services/CognitoService.php)

## Not working in out-of-the-box Laravel 8

- our implementation of tenants - stancl/tenancy has changed the structure
