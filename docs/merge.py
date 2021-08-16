# coding: utf8

def compile(fList, folder, result):
    res = ""

    # Lecture

    for el in fList:
        fileName = folder + "/" + el + ".md"

        with open(fileName, "r") as file:
            for line in file:
                if line[0] == "@":
                    line = line.strip()
                    part = line.split("@include ")
                    part = part[1]

                    incName = "examples/" + part + ".txt"

                    with open(incName, "r") as example:
                        for line in example:
                            res += line

                    res += "\n"

                    example.close()
                else:
                    res += line
        
        file.close()
    
        res += "\n" * 2

    # Ecriture

    with open(result, "w") as file:
        file.write(res)
        file.close()

    print("Le fichier " + result + " a été compilé.")

# Dossier de synthèse

report = ["ENL-base", "ENL-N1-intro", "ENL-N2-projet", "ENL-N3-competences", "ENL-N4-outils", "ENL-N5-cahier-charges"]
report += ["N5/ENL-N5.1-normes", "N5/ENL-N5.2-base", "N5/ENL-N5.3-accueil", "N5/ENL-N5.4-utilisateurs", "N5/ENL-N5.5-themes", "N5/ENL-N5.6-expressions"]
report += ["ENL-N6-conception", "ENL-N7-architecture", "ENL-N8-securite", "ENL-N9-extraits", "ENL-N10-ameliorations", "ENL-annexes"]

compile(report, "partials", "DS-ENL-LH.md")

# Tests

scenarios = ["S1-Base", "S2-Accueil", "S3-Users", "S4-Themes", "S5-Expressions"]

#compile(scenarios, "scenarios", "ENL-Tests.md")