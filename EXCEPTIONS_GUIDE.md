# 📋 Przewodnik po Obsłudze Wyjątków

## 🔧 **ULEPSZENIA WPROWADZONE**

### **1. Wzbogacone Klasy Wyjątków**

#### **AppException** - Bazowa klasa
```php
// Teraz z dodatkowymi informacjami
throw new AppException(
    'Technical message',
    1001,
    $previousException,
    ['context' => 'data'],    // Kontekst do debugowania
    'User-friendly message'   // Wiadomość dla użytkownika
);

// Dostępne metody:
$exception->getContext();      // Kontekst debugowania  
$exception->getUserMessage();  // Przyjazna wiadomość
$exception->getFullDetails();  // Wszystkie szczegóły
```

#### **StorageException** - Dla błędów bazy i plików
```php
// Statyczne metody dla różnych typów błędów:
StorageException::databaseConnection($details, $previousException);
StorageException::queryFailed($operation, $previousException, $context);
StorageException::dataNotFound($entity, $identifier);
StorageException::fileUpload($details, $fileInfo);
StorageException::transactionFailed($operation, $previousException);
```

#### **ValidationException** - Dla błędów walidacji
```php
ValidationException::invalidInput($field, $reason, $value);
ValidationException::missingField($field);
ValidationException::csrfTokenInvalid();
ValidationException::multipleErrors($errorsArray);

// Dostęp do błędów walidacji:
$exception->getValidationErrors();
$exception->hasValidationErrors();
```

#### **AuthException** - Dla błędów uwierzytelniania
```php
AuthException::loginFailed($reason, $previousException);
AuthException::invalidCredentials();
AuthException::accessDenied($resource);
AuthException::sessionExpired();
AuthException::userNotFound($identifier);
```

#### **NotFoundException** - Dla błędów 404
```php
NotFoundException::route($path);
NotFoundException::resource($type, $id);
NotFoundException::page($page);
```

### **2. Ulepszone Logowanie**

ErrorHandler teraz zapisuje:
- Szczegółowe logi JSON w `/logs/errors_YYYY-MM-DD.log`
- Informacje o kontekście, użytkowniku, żądaniu
- Stack trace i dodatkowe metadane

### **3. Inteligentna Obsługa Błędów**

```php
// Automatyczne kody HTTP:
NotFoundException     → 404
ValidationException   → 400  
AuthException        → 401/403
Inne                 → 500

// Obsługa AJAX:
return json_encode([
    'success' => false,
    'message' => $exception->getUserMessage(),
    'errors' => $exception->getValidationErrors() // Jeśli ValidationException
]);
```

### **4. TransactionManager Trait**

```php
class YourService {
    use TransactionManager;
    
    public function complexOperation() {
        // Automatyczny rollback w przypadku błędu
        $this->executeInTransaction(function() {
            $this->repository->operation1();
            $this->repository->operation2();
            // Jeśli któraś operacja się nie powiedzie - rollback
        });
    }
}
```

---

## 🚀 **JAK UŻYWAĆ NOWEGO SYSTEMU**

### **1. W Repozytoriach:**
```php
// ZAMIAST:
throw new StorageException("Błąd bazy danych");

// UŻYJ:
throw StorageException::queryFailed('user creation', $e, [
    'table' => 'users',
    'data' => $userData
]);
```

### **2. W Serwisach z Transakcjami:**
```php
// ZAMIAST:
try {
    $this->con->beginTransaction();
    // operacje...
    $this->con->commit();
} catch (Exception $e) {
    $this->con->rollBack();
    throw new StorageException("Błąd");
}

// UŻYJ:
$this->executeInTransaction(function() {
    // wszystkie operacje
});
```

### **3. W Kontrolerach:**
```php
// ZAMIAST:
throw new StorageException('Nie udało się zalogować');

// UŻYJ:
throw AuthException::loginFailed('Database connection failed', $e);
```

### **4. W Middleware:**
```php
// ZAMIAST:
header('Location: /?error=csrf');

// UŻYJ:
throw ValidationException::csrfTokenInvalid();
```

---

## 📊 **KORZYŚCI Z NOWEGO SYSTEMU**

### **✅ Co Zyskujesz:**
1. **Lepsze Debugowanie** - szczegółowe logi z kontekstem
2. **Przyjazne Komunikaty** - różne wiadomości dla użytkowników i deweloperów  
3. **Spójne Kody HTTP** - automatyczne mapowanie na właściwe kody
4. **Bezpieczne Transakcje** - automatyczny rollback
5. **Obsługa AJAX** - inteligentne response dla żądań asynchronicznych
6. **Kategoryzacja Błędów** - różne typy wyjątków dla różnych problemów
7. **Łatwiejsze Utrzymanie** - statyczne metody zamiast duplikacji kodu

### **🔄 Migracja Istniejącego Kodu:**
1. Znajdź wszystkie `throw new StorageException`
2. Zastąp odpowiednią statyczną metodą z kontekstem
3. Dodaj TransactionManager trait do serwisów
4. Zastąp manualne transakcje `executeInTransaction()`

---

## 🔍 **MONITORING BŁĘDÓW**

### **Lokalizacja Logów:**
```bash
/workspace/logs/errors_2024-01-15.log
```

### **Format Logów:**
```json
{
  "timestamp": "2024-01-15 14:30:22",
  "type": "App\\Exception\\StorageException", 
  "message": "Database query failed during: user creation",
  "context": {
    "operation": "user creation",
    "table": "users", 
    "data": {...}
  },
  "user_message": "Nie udało się utworzyć konta. Spróbuj ponownie.",
  "url": "/dashboard/create",
  "method": "POST",
  "ip": "192.168.1.100"
}
```

---

## 📚 **DALSZE ULEPSZENIA**

### **Co Można Jeszcze Dodać:**
1. **Email Notifications** - powiadomienia o krytycznych błędach
2. **Exception Dashboard** - panel do przeglądania błędów
3. **Rate Limiting** - ograniczenie zgłaszania identycznych błędów
4. **Integration z Sentry/Bugsnag** - external error tracking
5. **Automatic Recovery** - próby automatycznego naprawienia
6. **Performance Monitoring** - śledzenie wolnych zapytań

Nowy system obsługi wyjątków czyni aplikację bardziej niezawodną, łatwiejszą w debugowaniu i przyjazną dla użytkowników! 🎉