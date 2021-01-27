<?php
$cartp = get_cart();
?>

<h2>Selected</h2>
<table>
    <tbody>
    <?php if (!empty($cartp)): ?>
        <?php foreach ($cartp as $id => $picture): ?>
            <tr>
                <td>
                    <a href="view.php?id=<?= $id ?>">
						<img src="gallery/<?= $picture['tm']?>" alt="<?= $picture['nmphoto']?>" />
					</a>
                </td>
                <td><a href="view.php?id=<?= $id ?>&del=<?= $id ?>">Delete from selected</a>
				</td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="2">No selected!</td>
        </tr>
    <?php endif ?>
    </tbody>

</table>
