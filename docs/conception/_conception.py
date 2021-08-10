# coding: utf8

name = "ENL-Structure.md"

fList = ["1-base", "2-accueil", "3-utilisateurs", "4-themes", "5-expressions"]

res = ""

# Parties

for el in fList:
    filename = "ENL-Structure/" + el + ".md"

    with open(filename, "r") as file:
        res += file.read()

        file.close()
    
    res += "\n" * 2

# Résultat

with open(name, "w") as file:
    file.write(res)
    file.close()

print("Le fichier " + name + " a été compilé.")