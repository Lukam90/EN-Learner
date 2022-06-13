## Base de données

### Tables

**eleve**

|champ|type|
|-|-|
|**id**|integer|
|nom|varchar|
|prenom|varchar|
|**classe_id**|integer|

**professeur**

|champ|type|
|-|-|
|**id**|integer|
|nom|varchar|
|prenom|varchar|
|nb_heures|integer|

**classe**

|champ|type|
|-|-|
|**id**|integer|
|libelle|varchar|

**enseigne**

|champ|type|
|-|-|
|**professeur_id**|integer|
|**classe_id**|integer|

**principal**

|champ|type|
|-|-|
|**professeur_id**|integer|
|**classe_id**|integer|

**matiere**

|champ|type|
|-|-|
|**id**|integer|
|libelle|varchar|

**note**

|champ|type|
|-|-|
|**id**|integer|
|score|integer|
|date|datetime|
|**professeur_id**|integer|
|**eleve_id**|integer|
|**matiere_id**|integer|

### Relations

**professeur - note**

Un professeur attribue aucune ou plusieurs notes. (0,n)

Un note est attribuée par un seul professeur. (1,1)

**professeur - matiere**

Un professeur enseigne une seule matière. (1,1)

Une matière est enseignée par aucun ou plusieurs professeurs. (0,n)

**professeur - classe**

Un professeur enseigne à aucun ou plusieurs classes. (0,n)

Une classe a aucun ou plusieurs professeurs. (0,n)

Un professeur est le professeur principal d'aucune ou une seule classe. (0,1)

Une classe a aucun ou un seul professeur principal. (0,1)

**matiere - note**

Une matière est concernée par aucune ou plusieurs notes. (0,n)

Une note concerne une seule matière. (1,1)

**eleve - note**

Un élève reçoit aucune ou plusieurs notes. (0,n)

Une note concerne un seul et même élève. (1,1)

**eleve - classe**

Un élève est inscrit dans une seule classe. (1,1)

Une classe est rattachée à aucun ou plusieurs élèves. (0,n)

***