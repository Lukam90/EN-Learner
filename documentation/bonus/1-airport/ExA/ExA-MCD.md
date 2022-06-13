### Tables

**client**

|champ|type|
|-|-|
|**id**|integer|
|nom|varchar|
|prenom|varchar|
|adresse|varchar|
|cp|varchar|
|ville|varchar|

**aeroport**

|champ|type|exemple|
|-|-|-|
|**id**|integer||
|code|varchar (3)|SBX|
|adresse|varchar|route de l'aéroport|
|ville|varchar|Strasbourg|
|pays|varchar|FRANCE|

**avion**

|champ|type|exemple|
|-|-|-|
|**id**|integer||
|modele|varchar|EJ-78945|
|capacite|integer|200|
|compagnie|varchar|easyJet|

**vol**

|champ|type|exemple|
|-|-|-|
|**id**|integer|4800|
|direction|varchar (6)|aller, retour|
|date|datetime|samedi 14/09|
|heure_depart|time|06:00|
|heure_arrivee|time|7 h 50|
|classe|varchar|économique, business|
|nb_bagages|integer||
|**reservation_id**|integer||
|**aeroport_id**|integer||
|**avion_id**|integer||

**reservation**

|champ|type|exemple|
|-|-|-|
|**id**|integer|456789|
|prix|varchar|90 (€ TTC)|
|**client_id**|integer||

### Relations

**client - reservation**

Un client passe aucune ou plusieurs réservations. (0,n)

Une réservation est passée par un seul client. (1,1)

**reservation - vol**

Une réservation regroupe aucun ou plusieurs vols. (0,n)

Un vol concerne une seule réservation. (1,1)

**vol - avion**

Un vol est rattaché à un seul avion. (1,1)

Un avion est utilisé pour aucun ou plusieurs vols. (0,n)

**vol - aeroport**

Un vol est à destination d'un seul aéroport. (1,1)

Un aéroport est rattaché à aucun ou plusieurs vols. (0,n)