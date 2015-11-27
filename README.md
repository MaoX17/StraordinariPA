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
mysql PersStraordinari < ./sql/ruoli.sql

occorre poi creare un virtualHost o una directory e un relativo spazio sul webserver e copiarci tutti i file del progetto.
Il progetto è destinato aq un accesso in LAN, quindi si consiglia di installarlo sulla propria intranet

La connessione al DB è definita nel seguente file:

config.ini

Questa applicazione si integra con Active Directory di Microsoft per il login degli utenti.
Per configurare l'applicazione per il vostro dominio Active Directory dovrete andare a modificare il file

/class/adLDAP/src/adLDAP.php

e impostare i parametri del vostro dominio.

### Operazioni da svolgere sul DB

Per prima cosa sarebbe necessario far eseguire un primo login a tutti i dirigenti e al
responsabile dell'ufficio del personale che dovrà controllare le richieste di straordinario.

A questo punto la tabella "utenti" inizierà a popolarsi con gli utenti che hanno fatto login.
Occorre quindi assegnare il corretto "privilegio" ad ogni utente "particolare" (cioè proprio i dirigenti e il responsabile dell'ufficio del personale)
Nella tabella utenti i dirigenti dovranno avere id_ruolo = 2
Nella tabella utenti iresp. dell'ufficio del personale dovrà avere  id_ruolo = 3

Tutti gli altri utenti avranno di default id_ruolo = 1


Nella tabella "aree" occorre impostare il proprio "organigramma"
Occorre cioè aggiungere il nome dell'area e l'id del dirigente.

Nella Tabella "Aree" a questo punto occorre assegnare per ogni area il corretto dirigente.
Occorre inoltre specificare se il dirigente è anche titolare dell'area ('S') e se è abilitato ('S')
Questi paramentri servono per gestire le situazioni in cui un dirigente ne sostituisce un altro e deve
approvare gli straordinari al posto del sostituito.



## Credits
Applicazione realizzata dal CED della Provincia di Prato - Ufficio Sistemi Informativi Per informazioni o suggerimenti inviare una mail al seguente indirizzo webmaster@provincia.prato.it

