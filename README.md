# Hrana #
Hrana je spletna aplikacija, ki omogoča dijakom prijavo in odjavo od šolske prehrane.

## Zahteve za namestitev ##
Spletna aplikacija vsebuje funkcijo "Pozabljeno geslo", ki uporabniku omogoča ponovno nastavitev gesla. Za njeno delovanje je potrebno namestiti poštni strežnik, kot je npr. sendmail.

## Namestitev ##
V datoteki kontroler/Baza.php spremenite podatke za dostop do podatkovne baze.
```
$link=new mysqli("localhost","uporabnisko_ime","geslo","ime_podatkovne_baze");
```

Uvozite datoteko hrana.sql (npr. z orodjem phpmyadmin).

## Licenca ##
Projekt Hrana je narejen pod licenco MIT.

## Vzdrževanje ##
Če najdete kakršnokoli napako jo lahko sporočite prek [Github issue tracker](https://github.com/simon-horvat/hrana/issues)

