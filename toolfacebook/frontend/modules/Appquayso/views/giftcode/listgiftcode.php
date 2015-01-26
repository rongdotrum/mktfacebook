 <?php
        foreach ($listgift as $gift) {
            echo ' - <span style="font-weight: bold;">' . $gift['count'] . ' ' . $gift['itemname'] . '</span>';
            echo '</br>';
        }
        ?>