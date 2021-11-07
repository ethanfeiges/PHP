<html>
    <p>
        <!--"send data in as a post"-->
        <form method="post">
            <!--Series of input tags-->
            <!-- "name": What will be shown in  $_POST[] or $_GET[] -->
            <!--id tag (ALL IN BROWSER): Connecting the input tag with the label-->
            <!--Attribute of <label> must be equal to the id attribute of the related element to bind them together -->
            <p><label for="guess">Input Guess</label></p>
            <input type="text" name ="guess" id="guess"/></p>
            <!--submit button sends the data to the server through a get request -->
            <input type="submit"/>
        </form>
    </p>
    <pre>
        <?php
            print_r($_POST);

        ?>
    </pre>
    
    
</html>