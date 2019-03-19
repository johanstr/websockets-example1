# WebSockets Voorbeeld 1
  
## Introductie
In dit voorbeeld simuleren we een workshop aanmeld systeem waar je een plaats reserveert. Alle clients die aangemeld zijn krijgen
real-time te zien hoeveel plaatsen er nog beschikbaar zijn.
  

## Wat krijg je?
Je krijgt in dit voorbeeld een aantal bestanden, namelijk:
  
**index.php**  
Dit is de clientpage. Mensen die zich willen aanmelden voor een workshop komen op een dergelijke pagina binnen.  
  
**js/socket-client.js**  
Dit is de code in de client die een connectie maakt met de websocket server en vervolgens wacht op een reactie van de server.
Daarvoor maken we gebruik van de standaard JavaScript voorziening WebSocket, dit is een class met o.a. functionaliteit om de communicatie met een websocket server af te handelen.  
  
**socket-server.php**  
Dit is de feitelijke server. Deze gaan we starten en na een succesvolle start kunnen we de clients verbinden. Voor het programmeren van de server hebben we gebruik gemaakt van de package ***cboden/ratchet*** (zie packagist.org). Deze hebben middels de dependency manager van PHP, Composer, toegevoegd aan ons project.  
  
**ServerUpdate.php**  
In dit bestand hebben we geprogrammeerd hoe met de berichten van een client om te gaan. Als een van de clients een workshopplaats reserveert wordt dit vanuit JavaScript naar de websocket server gestuurd. Een dergelijk bericht wordt in deze code afgehandeld.  

##composer.json
Het bestand ***composer.json*** is in feite een *configuratie file* voor composer m.b.t. ons project. In dit bestand staan alle packages vermeldt die aan ons project zijn toegevoegd. Verder staat er ook nog in dat we via namespacing willen gaan werken.  

```json
{
    "name": "smn/websocket-example1",
    "description": "Dit is een voorbeeld van een Websocket systeem",
    "authors": [
        {
            "name": "Jouw naam",
            "email": "jouw mail"
        }
    ],
    "autoload": {
        "psr-4": {
            "MyApp\\": "app/"
        }
    },
    "require": {
        "cboden/ratchet": "^0.4.1"
    }
}
```  
  
In de regels vanaf *"autoload"* tot en met de regel boven *"require"* hebben dit gedaan.