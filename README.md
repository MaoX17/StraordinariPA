# StraordinariPA
Software php mysql per la gestione degli straordinari nella PA

Questa applicazione Web è scritta in php e sfrutta le funzionalità di PEAR/MDB2
Necessita di php >= 5.3.* e mysql >= 5.1.*

## Installazione

Questa applicazione necessita di PEAR/MDB2

Si prega di installarlo:
yum install php-pear.noarch
pear install MDB2
pear install MDB2#mysql

Per prima cosa occorre importare nel proprio db mysql la struttura dati

mysqladmin create PersStraordinari
mysql PersStraordinari < ./sql/PersStraordinari.sql

occorre poi creare un virtualHost o una directory e un relativo spazio sul webserver e copiarci tutti i file del progetto.
Il progetto è destinato aq un accesso in LAN, quindi si consiglia di installarlo sulla propria intranet

La connessione al DB è definita nel seguente file:

config.ini

Questa applicazione si integra con Active Directory di Microsoft per il login degli utenti.
Per configurare l'applicazione per il vostro dominio Active Directory dovrete andare a modificare il file

/class/adLDAP/src/adLDAP.php

e impostare i parametri del vostro dominio.

## Credits
Applicazione realizzata dal CED della Provincia di Prato - Ufficio Sistemi Informativi Per informazioni o suggerimenti inviare una mail al seguente indirizzo webmaster@provincia.prato.it

