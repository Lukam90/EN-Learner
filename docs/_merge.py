# coding: utf8

import sys

name = "DS-ENL-LH.md"

fList = []

res = ""

# Parties

with open("plan.txt", "r") as file:
    for line in file:
        if (line.strip() != ""):
            filename = "partials/" + line.strip() + ".md"
            fList.append(filename)
    
    file.close()

# Lecture

for el in fList:
    with open(el, "r") as file:
        for line in file:
            if line[0] == "@":
                parts = line.strip().split("@include ")
                incFile = "examples/" + parts[1] + ".txt"

                with open(incFile, "r") as file:
                    res += file.read() + "\n"
                    file.close()
            else:
                res += line

        file.close()
    
    res += "\n" * 2

# Résultat

with open(name, "w") as file:
    file.write(res)
    file.close()

print("Le fichier " + name + " a été compilé.")