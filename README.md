# Plentific code test (composer pakcage)

## Introduction
I have decided to write this README just to give a run through of the methogology I've used for this package.

Dependencies:
- GuzzleHttp
- PHPUnit

Classes:
- [HttpClient](./src/HttpClient.php) - Handles the http request to dummyjson.com
- [UserClass](./src/UserClass.php) - Handles fetching and create the user

Interfaces: 
- [CreateableInterface](./src/Interfaces/CreateableInterface.php)
- [HttpClientInterface](./src/Interfaces/HttpClientInterface.php)

Data Transfer Objects (DTOs)
- [UserDTO](./src/DTO/UserDTO.php)
- [PaginatedUserDTO](./src/DTO/PaginatedUserDTO.php)

---
The **UserClass** implements the ***CreateableInterface*** and ***UserFetchableInterface*** as these interfaces hold method signatures for the class.

I've also added an interface implementation on the **HttpClient**, ***HttpClientInterface*** which simply holds a single method signature for `request()`

DTOs are located in the DTO directory, I created two, one for a single **UserDTO** and a **PaginatedUserDTO** which returns and array of **UserDTOs**


Tests are located in the Test directory, i have incldued a single Feature test just to ping dummyjson.com essentially to ensure the host works.

I have included with the package, an accompanying Laravel application for displaying output. So not to detract away from the core exercise, I've kept the styling to an absolute minimum and simply dump the returned values in the blade templates - which can be manipulated via the query parameters

**UserClass** methods consist of:

```php

public function getUser(int $id, bool $returnJson = true): array|string;

public function getUsers(
    int $limit = 30, //limited to a maximum of 50
    int $skip = 0,
    array $select = [],
    bool $returnJson = true
): array|string;

public function create(array $data): int
```
**HttpClient** methods consist of:

```php
public function request(string $method, string $url, array $data = []): string
```
