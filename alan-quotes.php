<?php

/*
Plugin Name:    Alan Partridge Random Quote Widget
Description:    Display a random Alan Partridge quote.
Author:         Folderfabriek
Version:        1.0.0
Author URI:     https://www.folderfabriek.nl/wordpress-widget-alan-partridge-quote/
License:        GPL2
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
*/

// Register and load the widget
function alan_partridge_load_widget() {
    register_widget( 'alan_partridge_widget' );
}
add_action( 'widgets_init', 'alan_partridge_load_widget' );
 
// Creating the widget, create a class of alan_partridge_widget
class alan_partridge_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'alan_widget', 

        // Widget name will appear in UI
        __('Alan Partridge quote generator', 'alan_widget_domain'), 

        // Widget description
        array( 'description' => __( 'Displays random Alan Partridge quotes', 'alan_widget_domain' ), ) 
        );
    }

    // Creating widget front-end, meat 'n bones
    public function widget( $args, $instance ) {
                
        $title = apply_filters( 'widget_title', $instance['title'] );
        $season = $instance['season'];
        $styling = $instance['styling'];
        $link = $instance['link'];

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        // Open div wrapping widget front-end output: simplifies css selector styling, won't usually interfere with used theme's selector ID's, ie: #partridge-quotes #alan-on
        echo '<div id="partridge-quotes">';        
        
        // If set, echo optional CSS styles
        if ($styling == "Yes") {
            echo '<style type="text/css">#partridge-quotes #alan-on {margin-bottom: 10px; font-size: 13px} #partridge-quotes #alan-quote {line-height: 22px; margin-bottom: 10px; font-style: italic; font-size: 15px} #partridge-quotes #author-link {color: #686868; font-size: 10px} </style>';
        }

        // Array of Alan quotes: primary array of season 1 and season 2 quote-arrays, secondary array of alan-on and alan-quote strings
        $alanquotes = array
        (
            // Season 1 quotes
            array(
                array("Alan on Lynn's qualities", "Lynn's a good worker but I suppose she's a bit like Burt Reynolds. Very reliable but she's got a moustache."),
                array("Alan on bathrooms", "You know what this room says to me? Aqua. Which is French for water. It's like being inside an enormous Fox's Glacier Mint, which again, to me, is a bonus."),
                array("Alan on bicycles", "Mary Poppins! What's that?"),
                array("Alan ending a conversation", "Would it be terribly rude to stop talking to you and go speak to someone else?"),
                array("Alan on his favourite Beatles album", "Tough one! I think I’d have to say… ‘The Best Of The Beatles’."),
                array("Alan not getting a second series", "Smell my cheese you mother!"),
                array("Alan reflecting on a busy day", "I've been working like a Japanese prisoner of war... but a happy one."),
                array("Alan on calculations", "No offence Lynn, but technically your life's not worth insuring."),
                array("Alan on his ex wife", "Actually the best thing I did, was to get thrown out by my wife. She's living with a fitness instructor. He drinks that yellow stuff in tins. He's an idiot."),
                array("Alan on farmers", "If you see a lovely field with a family having a picnic, and there's a nice pond in it, you fill in the pond with concrete, you plough the family into the field, you blow up the tree, and use the leaves to make a dress for your wife who's also your brother."),
                array("Alan on Michael's accent", "I'm sorry, that was just a noise."),
                array("Alan on tables", "Yes, it's an extender! Fantastic! That is the icing on the cake."),
                array("Alan on a type of toilet", "I do like that toilet. It's very futuristic, isn't it? Very, sort of, high-tech, space age. I can imagine Buck Rogers taking a dump on that. In the twenty-first century. Can I, have a go?"),
                array("Alan on German music", "Kommen sie bitte und listen to Kraftwerk!"),
                array("Alan on the BBC", "I wish all you BBC 2 people would just get in a bus and drive over a cliff. I'd happily be the driver!"),
                array("Bored Alan", "Hi Susan. I was a bit bored so I dismantled my Corby Trouser Press. I can't put it back together again. Will that show up on my bill?"),
            ),
            
            // Season 2 quotes
            array(
                array("Alan on accidents", "Calm down Lynn! You're suffering from minor women's whiplash."),
                array("Alan on Lynn's mother", "She was a biiig woman. I'm tempted to say she was big hearted but that would be buuulshit."),
                array("Alan intro'ing a song", "Now, who's this beautiful blond man with a lovely voice? It's Annie lennox."),
                array("Alan on London", "Go to London, I guarantee you'll either be mugged or not appreciated. Catch the train to London, stopping at Rejection, Disappointment, Backstabbing Central and Shattered Dreams Parkway"),
                array("Alan on aids for the blind", "Guide dogs for the blind. It's cruel really, isn't it? Getting a dog to lead a man round all day. Not fair on either of them."),
                array("Alan introducing Lynn", "Lynn's not my wife. She's my PA. Hard-worker, but there's no affection."),
                array("Alan on Sonja's love", "Thanks a lot!"),
                array("Alan on getting Dan's attention", "Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Dan! Oh, he's not seeing me, I'll get him later... Dan!"),
                array("Alan on women's feet", "I don't like big feet. It reminds me of gammon."),
                array("Alan on food", "Crabsticks do not actually contain any crab and, since 1993, manufacturers have been legally obliged to call them crab-flavoured sticks."),
                array("Alan on food aesthetics", "I've got a chocolate Marble Arch. It's very well rendered."),
                array("Alan on breakfast", "Yeah, it's cholesterol, Scottish people eat it."),
            ),
            
        );
        
        $selectedseason = 0;
        
        // Set season array based on user setting, if 'Both seasons' are user-set, pick a random season
        switch ($season) {
            case 'Season 1':
                $selectedseason = 0;
                break;
            case 'Season 2':
                $selectedseason = 1;
                break;
            case 'Both seasons':
                $selectedseason = rand( 0, sizeof($alanquotes) - 1 );                
                break;
        }
        
        // Select a random index of alan-on and alan-quote strings in selected season array, subtract 1 because of zero-indexing
        $randomquote = rand( 0, sizeof($alanquotes[$selectedseason]) - 1 );
        
        // Echo alan-on and alan-quote found at selected random quote array in $alanquotes array
        echo '<p id="alan-on">' . $alanquotes[$selectedseason][$randomquote][0] . ':</p>';        
        echo '<p id="alan-quote"><strong>&quot;' . $alanquotes[$selectedseason][$randomquote][1] . '&quot;</strong></p>';
        
        // If $link is set to "yes", echo eeny-meeny link to author, yay me!
        if ($link == "Yes") {
            echo '<a title="Visit widget author" target="_blank" id="author-link" href="https://www.folderfabriek.nl/">Widget created by Folderfabriek</a>';
        }
        
        // Close div wrapping widget front-end output
        echo '</div>';
        
        // Add Wordpress after_widget arguments defined by theme
        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Alan Patridge quotes', 'alan_widget_domain' );
        }
        // Check if season exists, if its null, put "Both seasons" for use in the form
        if ( isset( $instance[ 'season' ] ) ) {
            $season = $instance[ 'season' ];
        }
        else {
            $season = __( 'Both seasons', 'alan_widget_domain' );
        }
        // Check if styling option exists, if its null, put "Yes" for use in the form
        if ( isset( $instance[ 'styling' ] ) ) {
            $styling = $instance[ 'styling' ];
        }
        else {
            $styling = __( 'Yes', 'alan_widget_domain' );
        }
        // Check if link option exists, if its null, put "Yes" for use in the form
        if ( isset( $instance[ 'link' ] ) ) {
            $link = $instance[ 'link' ];
        }
        else {
            $link = __( 'Yes', 'alan_widget_domain' );
        }
        
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'season' ); ?>"><?php _e( 'Display random quotes from which I\'m Alan Partridge season?' ); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'season' ); ?>" name="<?php echo $this->get_field_name( 'season' ); ?>" type="text">
                <option value='Both seasons'<?php echo ($season=='Both seasons')?'selected':''; ?>>
                    Both seasons
                </option>
                <option value='Season 1'<?php echo ($season=='Season 1')?'selected':''; ?>>
                    Season 1
                </option>
                <option value='Season 2'<?php echo ($season=='Season 2')?'selected':''; ?>>
                    Season 2
                </option>
            </select>                    
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'styling' ); ?>"><?php _e( 'Include rudimentary CSS?' ); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'styling' ); ?>" name="<?php echo $this->get_field_name( 'styling' ); ?>" type="text">
                <option value='Yes'<?php echo ($styling=='Yes')?'selected':''; ?>>
                    Yes
                </option>
                <option value='No'<?php echo ($styling=='No')?'selected':''; ?>>
                    No
                </option>
            </select>                    
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Add small link to author' ); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text">
                <option value='Yes'<?php echo ($link=='Yes')?'selected':''; ?>>
                    Yes
                </option>
                <option value='No'<?php echo ($link=='No')?'selected':''; ?>>
                    No
                </option>
            </select>                    
        </p>

    <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['season'] = ( !empty( $new_instance['season'] ) ) ? strip_tags( $new_instance['season'] ) : '';
        $instance['styling'] = ( !empty( $new_instance['styling'] ) ) ? strip_tags( $new_instance['styling'] ) : '';
        $instance['link'] = ( !empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
        return $instance;
    }
    
} // Class alan_partridge_widget ends here

?>
