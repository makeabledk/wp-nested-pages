<?php

namespace NestedPages\Entities\Confirmation;

/**
* Confirm page(s) moved to trash
*/
class TrashConfirmation implements ConfirmationInterface
{

	public function setMessage()
	{
		$trashed = ( explode(',', $_GET['ids']) );
		$post_type = get_post_type($trashed[0]);
		$post_type_object = get_post_type_object($post_type);
		
		$out = ( count($trashed) > 1 )
			? $out .= count($trashed) . ' ' . $post_type_object->labels->name . ' ' . __('moved to the Trash.', 'nestedpages')
			: $out .= '<strong>' . get_the_title($trashed[0]) . ' </strong>' . __('moved to the Trash.', 'nestedpages');			

		// Undo Link
		if ( current_user_can('delete_pages') ) {

			$ids = preg_replace( '/[^0-9,]/', '', $_GET['ids'] );
			
			$out .= ' <a href="' . wp_nonce_url( admin_url( 'edit.php?&post_type=' . $post_type . '&amp;doaction=undo'. '&amp;action=untrash&amp;ids=' . $ids ), 'bulk-posts') . '">' . __( 'Undo' ) . "</a>";
		}

		return $out;
	}

}
