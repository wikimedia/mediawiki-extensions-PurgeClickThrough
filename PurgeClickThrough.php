<?php
/**
 * @file
 *
 * Show a click through for the PURGE page instead of just redirecting.
 *
 * This is useful so that I can see the $wgDebugComments that happen on purge.
 *
 * Consider this extension to be in the public domain.
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'PurgeClickThrough',
	'version' => '0.1',
	'author' => 'Brian Wolff',
	// Not for real users, so no point i18n-ing it.
	'description' => 'Do not redirect ?action=purge pages, but instead have a click through (for debugging purposes)',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PurgeClickThrough',
);

$wgActions['purge'] = 'PurgeClickThrough';

class PurgeClickThrough extends PurgeAction {

        public function onSuccess() {
		$text = <<<WIKI
==Purge Succesful==
Continue on to the freshly purged page at 
WIKI;

		// Why is $this->redirectParams private instead of protected?

		$params = $this->getRequest()->getVal( 'redirectparams',
				wfArrayToCGI( array_diff_key(
					$this->getRequest()->getQueryValues(),
					array( 'title' => null, 'action' => null )
				))
			);

		$url = $this->getTitle()->getFullUrl( $params );
		$text .= '[' . $url . ' ' . $url . ']';
                $this->getOutput()->addWikiText( $text ); 
        }
}
