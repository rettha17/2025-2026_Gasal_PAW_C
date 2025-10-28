<?php
function show_form($errors = array(), $data = array()) {
?>
<form action="formValidate1.php" method="post">
    <p>
        <label for="surname">Surname:</label>
        <input type="text" name="surname" id="surname"
               value="<?php echo isset($data['surname']) ? htmlspecialchars($data['surname']) : ''; ?>">
        <?php
        if (isset($errors['surname'])) {
            echo "<span style='color:red;'> Error: " . htmlspecialchars($errors['surname']) . "</span>";
        }
        ?>
    </p>
    <p><input type="submit" value="Submit"></p>
</form>
<?php
}
?>
