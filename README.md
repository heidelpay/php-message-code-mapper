**heidelpay Customer Messages**

Diese Bibliothek dient zur benutzerfreundlichen Darstellung von (Fehler-) Meldungen
der heidelpay Schnittstelle.

***1. Installation***

_via Composer_
```
composer require heidelpay/php-customer-messages
```

_manuelle Installation_

Sie laden den aktuellen Release von github herunter und entpacken diesen in einen Ordner
Ihrer Wahl.

***2. Einbindung***

_via Composer_
```
require_once 'path/to/autoload.php;
use Heidelpay\CustomerMessages\CustomerMessage;
```

_bei manueller Installation_
```
require_once 'path/to/php-customer-messages/lib/CustomerMessage.php';
```
Der Pfad muss selbstverständlich an den realen Pfad der Bibliothek in der Applikation angepasst werden.

***3. Verwendung***

Angenommen, Sie erhalten einen Fehlercode aus einem Shopmodul oder bei Verwendung des
PHP SDKs. Dieser wird in einer Variable `$errorcode` gespeichert. Um den Inhalt dieses Fehlercodes in
eine Fehlermeldung umzuwandeln, muss zu erst eine Instanz von `CustomerMessage` initialisiert werden:
```
$instance = new \Heidelpay\CustomerMessages\CustomerMessage('de_DE');
```
Der Konstruktur nimmt zwei optionale Argumente: 1. Die Locale, 2. den Pfad zur Datei mit Codes und dazugehörigen
Fehlermeldungen.

Für die Locale 'de_DE' haben wir im Pfad _lib/locales_ bereits eine Liste an häufig auftretenden Fehlern
bereitgestellt, der Pfad muss daher nicht mit angegeben werden. Bekommt der Konstruktur kein Argument,
so ist 'en_US' die Standardsprache.

Nun kann über `$instance->getMessage($errorcode)` die Fehlermeldung in benutzerfreundlichem Format
ausgegeben werden.

Akzeptiert werden diese Errorcodes im Format '123.456.789' oder auch 'HPError-123.456.789'.
