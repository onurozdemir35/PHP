<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'library';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Die Verbindung zur Datenbank konnte nicht aufgebaut werden: ' . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bücher</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<body>
    <main class="py-5">
        <div class="container mb-5">
            <header class="mb-5">
                <h1>Unsere Bibliothek</h1>
                <p>Das hier ist unsere öffentliche Bibliothek. Unten haben wir dir eine Übersicht aller unserer Bücher aufgebaut.</p>
                <a href="#unsere-buecher" class="btn btn-primary">Zu den Büchern</a>
            </header>

            <?php
            if (isset($_GET['delete_book']) && is_numeric($_GET['delete_book'])) {
                $delete_book_id = filter_input(INPUT_GET, 'delete_book', FILTER_SANITIZE_NUMBER_INT);
                if ($delete_book_id != false && !empty($delete_book_id)) {
                    if (!isset($_GET['delete_book_confirm'])) {
                        $selectDeleteBookQuery = 'SELECT title FROM books b WHERE ID = ' . $delete_book_id;
                        $selectDeleteBookResult = $conn->query($selectDeleteBookQuery);
                        $selectDeleteBook = $selectDeleteBookResult->fetch_assoc();
            ?>
                        <div class="alert alert-warning" role="alert">
                            Soll das Buch <strong><?php echo $selectDeleteBook['title']; ?></strong> wirklich gelöscht werden?
                            <div class="mt-4">
                                <a href="?delete_book=<?php echo $delete_book_id; ?>&delete_book_confirm" class="btn btn-danger">Buch löschen</a>
                            </div>
                        </div>
                        <?php
                    }

                    if (isset($_GET['delete_book_confirm'])) {
                        $deleteBookQuery = 'DELETE FROM books WHERE ID = ' . $delete_book_id;

                        if ($conn->query($deleteBookQuery) === TRUE) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                Das Buch wurde erfolgreich gelöscht!
                            </div>
                            <div class="alert alert-info" role="alert">
                                Die Seite wird in wenigen Sekunden neu geladen.
                            </div>
            <?php
                            header("refresh:5;url=index.php");
                        }
                    }
                }
            }
            ?>

            <form class="border p-4 mb-4" method="post">
                <?php
                $edit_book_active = false;
                $form_title = 'Neues Buch anlegen';
                $form_description = 'Mit dem untenstehenden Formular kannst du ein neues Buch zu unserer Bibliothek hinzufügen.';
                $book_title = '';
                $book_description = '';
                $book_publishing_year = '';
                $book_publisher = 0;
                $privacy_text = 'Die in diesem Formular eingegebenen Daten werden verwendet, um ein neues Buch in unserer Datenbank anzulegen. Die Daten sind durch Absenden des Formular für die Öffentlichkeit einsehbar.';
                $submit_text = 'Neues Buch erstellen';

                // update book
                if (isset($_GET['edit_book']) && is_numeric($_GET['edit_book'])) {
                    $edit_book_id = filter_input(INPUT_GET, 'edit_book', FILTER_SANITIZE_NUMBER_INT);
                    if ($edit_book_id != false && !empty($edit_book_id)) {
                        $edit_book_active = true;

                        $updateBookQuery = 'SELECT b.ID as book_id, b.title as book_title, description, publishing_year, p.title as publisher_title, p.ID as publisher_id FROM books b, publisher p WHERE p.ID = b.publisher_id AND b.ID = ' . $edit_book_id;
                        $updateBookResult = $conn->query($updateBookQuery);
                        $updateBook = $updateBookResult->fetch_assoc();

                        $form_title = '„' . $updateBook['book_title'] . '“ bearbeiten';
                        $form_description = 'Mit dem untenstehenden Formular bearbeitest du das Buch <strong>' . $updateBook['book_title'] . '</strong>. <br>Durch Absenden des Formulars werden die Daten überschrieben.';
                        $book_title = $updateBook['book_title'];
                        $book_description = $updateBook['description'];
                        $book_publishing_year = $updateBook['publishing_year'];
                        $book_publisher = $updateBook['publisher_id'];
                        $privacy_text = 'Die in diesem Formular eingegebenen Daten werden verwendet, um das Buch <strong>' . $book_title . '</strong> in unserer Datenbank zu aktualisieren. <br><strong>Die Daten sind durch Absenden des Formular für die Öffentlichkeit einsehbar.</strong>';
                        $submit_text = 'Buch aktualisieren';
                    }
                }
                ?>

                <h2><?php echo $form_title; ?></h2>
                <p><?php echo $form_description; ?></p>

                <?php
                // create new book
                if (isset($_POST['new_book_title']) && isset($_POST['new_book_description']) && isset($_POST['new_book_publisher']) && isset($_POST['new_book_publishing_year'])) {
                    $new_book_title = filter_input(INPUT_POST, 'new_book_title', FILTER_SANITIZE_STRING);
                    $new_book_description = filter_input(INPUT_POST, 'new_book_description', FILTER_SANITIZE_STRING);
                    $new_book_publisher = filter_input(INPUT_POST, 'new_book_publisher', FILTER_SANITIZE_NUMBER_INT);
                    $new_book_publishing_year = filter_input(INPUT_POST, 'new_book_publishing_year', FILTER_SANITIZE_NUMBER_INT);

                    if (
                        $new_book_title != false && !empty($new_book_title)
                        && $new_book_description != false && !empty($new_book_description)
                        && $new_book_publisher != false && !empty($new_book_publisher)
                        && $new_book_publishing_year != false && !empty($new_book_publishing_year)
                    ) {
                        if ($edit_book_active) {
                            $updateBookQuery = 'UPDATE books SET title = "' . $new_book_title . '", description = "' . $new_book_description . '", publishing_year = ' . $new_book_publishing_year . ', publisher_id = ' . $new_book_publisher . ' WHERE ID = ' . $edit_book_id;

                            if ($conn->query($updateBookQuery) === TRUE) {
                ?>
                                <div class="alert alert-success" role="alert">
                                    Das Buch <strong><?php echo $new_book_title; ?></strong> wurde erfolgreich bearbeitet!
                                </div>
                                <div class="alert alert-info" role="alert">
                                    Die Seite wird in wenigen Sekunden neu geladen.
                                </div>
                            <?php
                                header("refresh:5;url=index.php");
                            }
                        } else {
                            $insertBookQuery = 'INSERT INTO books (title, description, publishing_year, publisher_id) VALUES ("' . $new_book_title . '", "' . $new_book_description . '", ' . $new_book_publishing_year . ', ' . $new_book_publisher . ')';

                            if ($conn->query($insertBookQuery) === TRUE) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    Das Buch <strong><?php echo $new_book_title; ?></strong> wurde erfolgreich erstellt!
                                </div>
                <?php
                            }
                        }
                    }
                }
                ?>

                <div class="mb-4">
                    <label for="new_book_title" class="form-label">Buchtitel</label>
                    <input type="text" class="form-control" placeholder="Der Titel des Buches" id="new_book_title" name="new_book_title" aria-describedby="new_book_title_help" value="<?php echo $book_title; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="new_book_description" class="form-label">Kurzbeschreibung</label>
                    <textarea class="form-control" placeholder="Gebe hier eine kurze Beschreibung des Buches ein (max. 150 Zeichen)." id="new_book_description" name="new_book_description" required><?php echo $book_description; ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="new_book_publishing_year" class="form-label">Erscheinungsjahr</label>
                    <input type="number" class="form-control" placeholder="Trage hier das Erscheinungsjahr ein." id="new_book_publishing_year" name="new_book_publishing_year" value="<?php echo $book_publishing_year; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="new_book_publisher" class="form-label">Verlag</label>
                    <select class="form-select" id="new_book_publisher" name="new_book_publisher" aria-label="Verlagsauswahl für das neue Buch" required>
                        <option selected>Verlag auswählen</option>
                        <?php
                        $getPublishersQuery = 'SELECT ID, title FROM publisher';
                        $publisherResult = $conn->query($getPublishersQuery);

                        if ($publisherResult->num_rows > 0) {
                            while ($publisher = $publisherResult->fetch_assoc()) {
                                if ($book_publisher > 0 && $publisher['ID'] == $book_publisher) {
                                    echo '<option value="' . $publisher['ID'] . '" selected>' . $publisher['title'] . '</option>';
                                }
                                echo '<option value="' . $publisher['ID'] . '">' . $publisher['title'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="new_book_acceptance">
                    <label class="form-check-label" for="new_book_acceptance"><?php echo $privacy_text; ?></label>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $submit_text; ?></button>
            </form>
        </div>
        <div id="unsere-buecher" class="container">
            <h2 class="mb-4">Unsere Bücher</h2>
            <div class="row">
                <?php
                $getBooksQuery = 'SELECT b.ID as book_id, b.title as book_title, description, publishing_year, p.title as publisher_title FROM books b, publisher p WHERE p.id = b.publisher_id';
                $result = $conn->query($getBooksQuery);

                if ($result->num_rows > 0) {
                    while ($book = $result->fetch_assoc()) {
                ?>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $book['book_title']; ?></h5>
                                    <p class="card-text"><?php echo $book['description']; ?></p>
                                    <p class="text-secondary">Erscheinungsjahr: <?php echo $book['publishing_year']; ?><br>Verlag: <?php echo $book['publisher_title']; ?></p>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="?edit_book=<?php echo $book['book_id']; ?>" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i> Bearbeiten</a>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <a href="?delete_book=<?php echo $book['book_id']; ?>" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Löschen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>