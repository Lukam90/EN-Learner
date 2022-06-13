filenames = ["ExE-I", "ExE-MCD", "ExE-C", "Ex-E1", "Ex-E2", "Ex-E3", "Ex-E4", "Ex-E5", "Ex-E6", "Ex-E7", "Ex-E8", "Ex-E9", "Ex-E10", "Ex-E11", "Ex-E12", "Ex-E13"]

with open('Ex-Ecole-Lucien-HAMM.md', 'w') as outfile:
    for fname in filenames:
        with open("ExE/" + fname + ".md") as infile:
            for line in infile:
                outfile.write(line)
            
            outfile.write("\n" * 2)

print("Compilation de Ex-Ecole")