# tecnoteca

TODO:
tabella articoli:

- id_articolo INT
- numero inventario VARCHAR
- tipologia SET(hardware, software)
- categoria SET(computer, tablet, ebook, console)
- stato SET(disponibile, guasto, prenotato, in prestito)
- fk_id_centro INT

tabella centri:

- id_centro INT
- nome VARCHAR
- città VARCHAR
- indirizzo VARCHAR

tabella utenti:

- id_utente INT
- nome VARCHAR
- cognome VARCHAR
- indirizzo VARCHAR
- email VARCHAR
- password VARCHAR
- tipologia_utente SET(cliente, operatore, amministratore)

tabella prestiti:

- id_prestito INT
- data_inizio_prestito DATE
- data_fine_prestito DATE
- fk_id_utente INT
- fk_id_articolo INT

tabella prenotazioni:

- id_prenotazione INT
- data_inizio_prenotazione DATE
- fk_id_utente INT
- fk_id_articolo INT
