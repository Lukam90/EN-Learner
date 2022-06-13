filenames = ["ExA-I", "ExA-MCD", "Ex-A1", "Ex-A2", "Ex-A3", "Ex-A4", "Ex-A5", "Ex-A6", "Ex-A7", "Ex-A8"]

with open('Ex-Airport-Lucien-HAMM.md', 'w') as outfile:
    for fname in filenames:
        with open("ExA/" + fname + ".md") as infile:
            for line in infile:
                outfile.write(line)
            
            outfile.write("\n" * 2)

print("Compilation de Ex-Airport")