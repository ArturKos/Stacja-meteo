# Stacja-meteo

Stacja pogodowa która dokonuje pomiarów temperatury oraz wilgotności wewnątrz mieszkania oraz na zewnątrz. Stacja powstała bazując na artykule ze strony majsterkowo.pl użytkownika r.blaszczak https://majsterkowo.pl/solarna-stacja-meteo-z-wykorzystaniem-wemos-d1-mini-pro-oraz-raspberry-pi-3-b-czesc-2. Oczywiście projekt został zmodyfikowany zgodnie z własnym pomysłem.

Założenia projektu:

-pomiar temperatury i wilgotności wewnątrz i na zewnątrz

-zapisanie pomiaru na serwerze lokalnym

-wyświetlenie ostatniego pomiaru oraz historii w formie wykresu na stronie www

-zbudowanie aplikacji dla systemu Android

-wyświetlenie ostatniego pomiaru w formie widgetu dla Windows 10


Zasilanie stacji w odróżnieniu od opisanego w artykule zrealizowane z sieci energetycznej. Użyto żył z przewodu sieciowego (tzw. „skrętki”) po około 2m długości do połączenia sensorów z ESP8266.

Wykorzystane części:

- Rsberry Pi 4 (wykorzystano wersję z 4 GiB RAM)

- ESP8266

- Czujnik wilgotności i temperatury DTH11

- Czujnik wilgotności i temperatury DTH22
