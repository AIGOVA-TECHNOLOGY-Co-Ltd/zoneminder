<?php
//
// ZoneMinder web settings view file, $Date$, $Revision$
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

if ( !canView( 'Control' ) )
{
    $_REQUEST['view'] = "error";
    return;
}
$monitor = dbFetchMonitor( $_REQUEST['mid'] );

$zmuCommand = getZmuCommand( " -m ".$_REQUEST['mid']." -B -C -H -O" );
$zmuOutput = exec( escapeshellcmd( $zmuCommand ) );
list( $brightness, $contrast, $hue, $colour ) = split( ' ', $zmuOutput );

$monitor['Brightness'] = $brightness;
$monitor['Contrast'] = $contrast;
$monitor['Hue'] = $hue;
$monitor['Colour'] = $colour;

$focusWindow = true;

xhtmlHeaders(__FILE__, $monitor['Name']." - ".$SLANG['Settings'] );
?>
<body>
  <div id="page">
    <div id="header">
      <h2><?= $monitor['Name'] ?> - <?= $SLANG['Settings'] ?></h2>
    </div>
    <div id="content">
      <form name="contentForm" id="contentForm" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <input type="hidden" name="view" value="<?= $_REQUEST['view'] ?>"/>
        <input type="hidden" name="action" value="settings"/>
        <input type="hidden" name="mid" value="<?= $_REQUEST['mid'] ?>"/>
        <table id="contentTable" class="major" cellspacing="0">
          <tbody>
            <tr>
              <td><?= $SLANG['Brightness'] ?></td>
              <td><input type="text" name="newBrightness" value="<?= $monitor['Brightness'] ?>" size="8"<?php if ( !canView( 'Control' ) ) { ?> disabled="disabled"<?php } ?>/></td>
            </tr>
            <tr>
              <td><?= $SLANG['Contrast'] ?></td>
              <td><input type="text" name="newContrast" value="<?= $monitor['Contrast'] ?>" size="8"<?php if ( !canView( 'Control' ) ) { ?> disabled="disabled"<?php } ?>/></td>
            </tr>
            <tr>
              <td><?= $SLANG['Hue'] ?></td>
              <td><input type="text" name="newHue" value="<?= $monitor['Hue'] ?>" size="8"<?php if ( !canView( 'Control' ) ) { ?> disabled="disabled"<?php } ?>/></td>
            </tr>
            <tr>
              <td><?= $SLANG['Colour'] ?></td>
              <td><input type="text" name="newColour" value="<?= $monitor['Colour'] ?>" size="8"<?php if ( !canView( 'Control' ) ) { ?> disabled="disabled"<?php } ?>/></td>
            </tr>
          </tbody>
        </table>
        <div id="contentButtons">
          <input type="submit" value="<?= $SLANG['Save'] ?>"<?php if ( !canView( 'Control' ) ) { ?> disabled="disabled"<?php } ?>/><input type="button" value="<?= $SLANG['Close'] ?>" onclick="closeWindow()"/>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
