const tipsTitle = document.getElementById("tips-title");
const errorsTitle = document.getElementById("errors-title");

const formTitle = document.getElementById("form-title");

function validateModal() {
    let tips = tipsTitle.value;
    let errors = errorsTitle.value;
    
    let title = formTitle.value;

    let nb = title.length;

    if (title) {
        if (nb <= 50) {
            
        }
    } else {
        tipsTitle.value = "Le titre doit être renseigné.";
    }
}

/*
if (! Post::empty("title")) {
            $title = Post::var("title");
    
            if (strlen($title) <= 50) {
                $exists = $this->themeModel->findOneByTitle($title);
    
                if (! $exists) {
                    $this->erase("title");
                } else {
                    $this->setError("title", "Le thème existe déjà. Veuillez saisir un autre titre.");
                }
            } else {
                $this->setError("title", "Le titre ne doit pas dépasser 50 caractères.");
            }
        } else {
            $this->setError("title", "Le titre doit être renseigné.");
        }
*/