# Zadanie rekrutacyjne

Stwórz obiektowy mechanizm (model) koszyka zakupowego w oparciu o testy (TDD).
 Twoim zadaniem jest napisanie klas: `Product` (_produkt_), `Item` (_pozycja w
 koszyku_), `Cart` (_koszyk_) oraz `Order` (_zamówienie_). Dodatkowe wytyczne:

* każdy produkt ma swoją nazwę i cenę,
* podczas dodawania produktu do koszyka użytkownik podaje liczbę zamawianych
 sztuk (ang. _quantity_),
* produkty mają zdefiniowaną minimalną liczbę sztuk, jaką można zamówić;
 domyślnie dla każdego produktu powinna ona wynosić **1**; jeżeli użytkownik
 wybierze mniejszą ilość, należy zwrócić błąd (wyjątek),
* koszyk powinien operować na groszach – żeby uniknąć błędów operacji
 zmiennoprzecinkowych,
* kod powinien być zgodny z "Czystą Architekturą" (ang. _Clean Architecture_),
 w szczególności zwracając uwagę na zarządzanie wyjątkami, poprawne nazewnictwo
 metod i SRP.

W katalogu `tests/` znajdują się testy, które określają strukturę wyżej
 wymienionych klas. Przygotuj implementację mechanizmu w taki sposób, aby testy
 się powiodły. Swoje rozwiązanie umieść w folderze `src/`.

Aby uprościć zadanie, nie przejmuj się przechowywaniem koszyka w sesji ani w
 bazie danych. Nie musisz także pisać kontrolerów, ani widoków. Zadanie polega
 wyłącznie na stworzeniu modelu.

Pilnuj formatowania zgodnego z PSR-1 i PSR-2. Pomoże Ci w tym Code Sniffer,
 który jest skonfigurowany w pliku `phpcs.xml.dist`.

#### Dodatkowo punktowane zadanie

Do stworzonego mechanizmu dodaj testy i ich implementację. Warunki zadania:

Przy każdym produkcie wprowadź stawkę podatku (ang. _tax_) w wysokości 0%, 5%,
 8% lub 23%, co umożliwi wyliczenie wartości brutto tego produktu.

Dodatkowo dodaj możliwość pobrania wartości brutto (ang. _gross_) wszystkich
 produktów w koszyku poprzez metodę `getTotalPriceGross()`. Zmodyfikuj także
 odpowiedź `getDataForView()` w klasie `Order` w taki sposób, aby każdy produkt
 miał podaną stawkę podatku (_string_, np. `23%`) oraz cenę brutto i sumę
 koszyka brutto (będzie to wymagało również zmiany testu).

## Uruchamianie testów

### Docker

Do repozytorium dołączona jest konfiguracja PHP w kontenerze Dockera. Po
 uruchomieniu komendy:

```bash
docker-compose up
```

 zostanie pobrany obraz PHP 7.2 oraz uruchomione testy (PHPUnit) i walidacja
 zgodności kodu z PSR-1 oraz PSR-2 (CodeSniffer).

### Manualne

Wymagane jest posiadanie PHP 7.2 oraz Composera. W pierwszej kolejności należy
 zainstalować paczki Composerowe:

```bash
composer install
```

 następnie uruchamiać testy i sniffing:

```bash
./vendor/bin/phpunit
./vendor/bin/phpcs -p
```
