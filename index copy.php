<?php
include "connexion.php";

// Récupérer les publications actives
$req = "SELECT * FROM publications WHERE statut = 'Actif' ORDER BY id_publication DESC";
$result = mysqli_query($connexion, $req);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBLICATIONS - Liste des pubs actives</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .like-button {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .like-button:hover {
            transform: scale(1.1);
            background-color: #dc3545;
            color: white;
        }
        .like-button.liked {
            background-color: #dc3545;
            color: white;
        }
        .like-count {
            font-weight: bold;
            margin-left: 5px;
        }
        .card-footer {
            background-color: transparent;
            border-top: 1px solid rgba(0,0,0,.125);
        }
    </style>
</head>
<body>
    <div class="fixed-top mb-3">
        <?php include('menu.php'); ?>
    </div>

    <div class="container mt-5 pt-5">
        
        <?php if (isset($_GET['like'])): ?>
            <?php if ($_GET['like'] == 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> Like ajouté avec succès !
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['like'] == 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> Erreur lors de l'ajout du like.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <h3 class="text-primary fw-bold mb-4">
            <i class="fas fa-thumbs-up me-2"></i>Liste des pubs actives
        </h3>

        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($row['photo'])): ?>
                                <img src="uploads/<?php echo $row['photo']; ?>"
                                     class="card-img-top"
                                     style="height:200px; object-fit:cover;"
                                     alt="Image de la publication">
                            <?php else: ?>
                                <div style="height:200px; background-color:#e9ecef; display:flex; align-items:center; justify-content:center;" class="card-img-top">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title fw-bold">
                                    <?php echo htmlspecialchars($row['contenu']); ?>
                                </h5>
                                
                            </div>

                            
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <a href="like.php?id_publication=<?php echo $row['id_publication']; ?>" 
                                       class="btn btn-outline-danger btn-sm like-button"
                                       >
                                        <i class="fas fa-thumbs-up"></i>
                                    </a>
                                    <span class="like-count">
                                        <?php echo $row['nbr_j_aime'] ?? 0; ?> 
                                        <?php echo ($row['nbr_j_aime'] ?? 0) <= 1 ? 'like' : 'likes'; ?>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-share-alt me-1"></i>Partager
                                </small>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Aucune publication active pour le moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>