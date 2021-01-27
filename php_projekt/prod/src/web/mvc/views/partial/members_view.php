<div id="members" > 

    <table border='0' cellpadding = "5" cellspacing = "5">
        
        <tbody>
        <?php
		
		if (!empty($members)): ?>
            <?php foreach ($members as $id => $member): ?>
                <tr>
                    <td>
                        <?= $member['name'] ?>
                    </td> 
                    <td>
                        <?= $member['email'] ?>
                    </td>
                    <td>
                        <a href="anketa?del=<?= $member['_id'] ?>"> Delete</a>
                    </td>					
					
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No members</td>
            </tr>
        <?php endif ?>
        </tbody>

    </table>

</div>
