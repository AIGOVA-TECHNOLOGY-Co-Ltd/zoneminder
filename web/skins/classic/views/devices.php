<?php
//
// ZoneMinder web devices file, $Date$, $Revision$
// Copyright (C) 2003, 2004, 2005, 2006  Philip Coombes
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//

if ( !canView( 'Devices' ) )
{
    $_REQUEST['view'] = "error";
     return;
}

$sql = "select * from Devices where Type = 'X10' order by Name";
$devices = array();
foreach( dbFetchAll( $sql ) as $row )
{
    $row['Status'] = getDeviceStatusX10( $row['KeyString'] );
    $devices[] = $row;
}

xhtmlHeaders(__FILE__, $SLANG['Devices'] );
?>
<body>
  <div id="page">
    <div id="header">
      <h2><?= $SLANG['Devices'] ?></h2>
    </div>
    <div id="content">
      <form name="contentForm" method="get" action="<?= $_SERVER['PHP_SELF'] ?>">
        <input type="hidden" name="view" value="none"/>
        <input type="hidden" name="action" value="device"/>
        <input type="hidden" name="key" value=""/>
        <input type="hidden" name="command" value=""/>
        <table id="contentTable" class="major" cellspacing="0">
          <tbody>
<?php
foreach( $devices as $device )
{
    if ( $device['Status'] == 'ON' )
    {
        $fclass = "infoText";
    }
    elseif ( $device['Status'] == 'OFF' )
    {
        $fclass = "warnText";
    }
    else
    {
        $fclass = "errorText";
    }
?>
            <tr>
              <td><?= makePopupLink( '?view=device&did='.$device['Id'], 'zmDevice', 'device', '<span class="'.$fclass.'">'.$device['Name'].' ('.$device['KeyString'].')</span>', canEdit( 'Devices' ) ) ?></td>
              <td><input type="button" value="<?= $SLANG['On'] ?>"<?= ($device['Status'] != 'ON')?' class="set"':'' ?> onclick="switchDeviceOn( this, '<?= $device['KeyString'] ?>' )"<?= canEdit( 'Devices' )?"":' disabled="disabled"' ?>/></td>
              <td><input type="button" value="<?= $SLANG['Off'] ?>"<?= ($device['Status'] != 'OFF')?' class="set"':'' ?> onclick="switchDeviceOff( this, '<?= $device['KeyString'] ?>' )"<?= canEdit( 'Devices' )?"":' disabled="disabled"' ?>/></td>
              <td><input type="checkbox" name="markDids[]" value="<?= $device['Id'] ?>" onclick="configureButtons( this, 'markDids' );"<?php if ( !canEdit( 'Devices' ) ) {?> disabled="disabled"<?php } ?>/></td>
            </tr>
<?php
}
?>
          </tbody>
        </table>
        <div id="contentButtons">
          <input type="button" value="<?= $SLANG['New'] ?>" onclick="createPopup( '?view=device&did=0', 'zmDevice', 'device' )"<?= canEdit('Devices')?'':' disabled="disabled"' ?>/>
          <input type="button" name="deleteBtn" value="<?= $SLANG['Delete'] ?>" onclick="deleteDevice( this )" disabled="disabled"/>
          <input type="button" value="<?= $SLANG['Cancel'] ?>" onclick="closeWindow();"/>
      </form>
    </div>
  </div>
</body>
</html>
