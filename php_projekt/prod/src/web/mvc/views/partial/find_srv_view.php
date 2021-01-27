<div id="cart">

    <table> 
        
        <tbody>
        <?php
		
		if (!empty($photos)): ?>
            <?php foreach ($photos as $id => $photo): ?>
                <tr>
                    <td>
                        <a href="photo?id=<?= $photo['_id'] ?>"><img src="/gallery/<?= $photo['tm']?>" alt="<?= $photo['nmphoto']?>" /></a>
                    </td>                    
					<td>
					Autor: <?= $photo['auphoto']?> <br/>Name: <?= $photo['nmphoto']?><br/>
					Description: <?= $photo['desc']?> <br/>Privacy: 
					<?php
						if($photo['privat']==='2')
							echo " Public";
						else
							echo " Private";	
					?>						
					</td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No photos</td>
            </tr>
        <?php endif ?>
        </tbody>

    </table>

</div>
