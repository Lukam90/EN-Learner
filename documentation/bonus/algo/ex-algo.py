filenames = ["exI", "ex1", "ex2", "ex3", "ex4", "ex5", "ex6", "ex7", "ex8", "ex9", "ex10", "ex-tri"]

with open('Ex-Algo-Lucien-HAMM.md', 'w') as outfile:
    for fname in filenames:
        with open("Ex-Algo/" + fname + ".md") as infile:
            for line in infile:
                outfile.write(line)
            
            outfile.write("\n" * 2)

print("Compilation de Ex-Algo")