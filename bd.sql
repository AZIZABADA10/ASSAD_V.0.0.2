select v.titre , v.idUtilisateur
from visiteGuide v inner join commentaire c on v.id = c.idVisiteGuide;