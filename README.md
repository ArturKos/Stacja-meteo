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
Docelowo widok strony www na poniższym obrazie
![image](https://user-images.githubusercontent.com/17749811/152382116-4bd5a943-fe65-445e-ac0e-efde6e95eb74.png)
Widok widgetu w Windows 10
![image](https://user-images.githubusercontent.com/17749811/152382146-2905884a-bba2-4f61-bc8e-0590faead913.png)
Widok aplikacji Android
![image](https://user-images.githubusercontent.com/17749811/152382169-8d5b88af-091a-46cf-8e99-3540f27270eb.png)
