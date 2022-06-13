## Base de données

### Tables

**salle**

|champ|type|
|-|-|
|**id**|integer|
|capacité|integer|

**film**

|champ|type|
|-|-|
|**id**|integer|
|titre|varchar|
|duree|integer|
|synopsis|text|
|**salle_id**|integer|
|**realisateur_id**|integer|

**realisateur**

|champ|type|
|-|-|
|**id**|integer|
|nom|varchar|
|prenom|varchar|

**seance**

|champ|type|
|-|-|
|**id**|integer|
|prix|double|
|date|datetime|
|horaire|time|
|diffusion|varchar|
|avant_premiere|bool|
|**salle_id**|integer|

### Relations

**seance - salle**

Une salle concerne aucune ou plusieurs séances. (0,n)

Une séance se déroule dans une seule salle. (1,1)

**salle - film**

Une salle diffuse aucun ou plusieurs films. (0,n)

Un film est diffusé dans une seule salle. (1,1)

**film - realisateur**

Un film est réalisé par un seul réalisateur. (1,1)

Un réalisateur réalise aucun ou plusieurs films. (0,n)