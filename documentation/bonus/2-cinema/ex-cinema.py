filenames = ["ExC-I", "ExC-MCD", "ExC-1", "ExC-2a", "ExC-2b", "ExC-2c", "ExC-2d", "ExC-2e", "ExC-2f", "ExC-2g"]

with open('Ex-Cinema-Lucien-HAMM.md', 'w') as outfile:
    for fname in filenames:
        with open("ExC/" + fname + ".md") as infile:
            for line in infile:
                outfile.write(line)
            
            outfile.write("\n" * 2)

print("Compilation de Ex-Cinema")