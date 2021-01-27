<div id="cart">
<?php
$cartp = get_cartp();
?>

<h2>Selected:</h2>
<table>
    <tbody>
    <?php if (!empty($cartp)): ?>
        <?php foreach ($cartp as $id => $picture): ?>
            <tr>
                <td>
                    <a href="photo?id=<?= $id ?>">
						<img src="/gallery/<?= $picture['tm']?>" alt="<?= $picture['nmphoto']?>" />
					</a>
                </td>
                <td>
				</td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="2">No saved!</td>
        </tr>
    <?php endif ?>
    </tbody>

</table>

</div>