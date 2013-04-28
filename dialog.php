<?php

    /*
    *  Copyright (c) Codiad & Kent Safranski (codiad.com), distributed
    *  as-is and without warranty under the MIT License. See 
    *  [root]/license.txt for more. This information must remain intact.
    */

    require_once('../../common.php');
    
    //////////////////////////////////////////////////////////////////
    // Verify Session or Key
    //////////////////////////////////////////////////////////////////
    
    checkSession();

    switch($_GET['action']){
            
        //////////////////////////////////////////////////////////////////////
        // Update
        //////////////////////////////////////////////////////////////////////
        
        case 'check':
        
            if(file_exists(BASE_PATH . "/data/" . $_SESSION['user'] . '_acl.php')){ 
            ?>
            <label>Restricted</label>
            <pre>You can not check for updates</pre>
            <button onclick="codiad.modal.unload();return false;">Close</button>
            <?php } else {
                require_once('class.autoupdate.php');
                $update = new AutoUpdate();
                $vars = json_decode($update->Check(), true);
            ?>
            <form>
            <input type="hidden" name="archive" value="<?php echo $vars[0]['data']['archive']; ?>">
            <input type="hidden" name="remoteversion" value="<?php echo $vars[0]['data']['remoteversion']; ?>">
            <label>Auto Update Check</label>
            <br><table>
                <tr><td>Your Version</td><td><?php echo $vars[0]['data']['currentversion']; ?></td></tr>
                <tr><td>Latest Version</td><td><?php echo $vars[0]['data']['remoteversion']; ?></td></tr>
            </table>
            <?php if($vars[0]['data']['currentversion'] != $vars[0]['data']['remoteversion']) { ?>
            <br><label>Changes on Codiad</label>
            <pre style="overflow-x: auto; overflow-y: scroll; max-height: 200px; max-width: 450px;"><?php echo $vars[0]['data']['message']; ?></pre>
            <?php } else { ?>
            <br><br><b><label>Congratulation, your system is up to date.</label></b>
            <?php if($vars[0]['data']['name'] != '') { ?>
            <em>Last update was done by <?php echo $vars[0]['data']['name']; ?>.</em>
            <?php } } ?>
            <br><br><?php
                if($vars[0]['data']['currentversion'] != $vars[0]['data']['remoteversion']) {
                    if($vars[0]['data']['autoupdate'] == '1') {
                        echo '<button class="btn-left" onclick="codiad.autoupdate.update();return false;">Update Codiad</button>&nbsp;<button class="btn-left" onclick="codiad.autoupdate.download();return false;">Download Codiad</button>&nbsp;';
                    } else {
                        echo '<button class="btn-left" onclick="codiad.autoupdate.update();return false;">Test Permission</button>&nbsp;<button class="btn-left" onclick="codiad.autoupdate.download();return false;">Download Codiad</button>&nbsp;';
                    }
                }
            ?><button class="btn-right" onclick="codiad.modal.unload();return false;">Cancel</button>
            <form>
            <?php }
            break;
            
        //////////////////////////////////////////////////////////////////
        // Update
        //////////////////////////////////////////////////////////////////
        
        case 'update':
            ?>
            <form>
            <input type="hidden" name="remoteversion" value="<?php echo($_GET['remoteversion']); ?>">
            <label>Confirm Update</label>
            <pre>Update: <?php echo($_GET['remoteversion']); ?></pre>
            <button class="btn-left">Confirm</button>&nbsp;<button class="btn-right" onclick="codiad.modal.unload(); return false;">Cancel</button>
            <form>
            <?php
            break;
            
    }
    
?>