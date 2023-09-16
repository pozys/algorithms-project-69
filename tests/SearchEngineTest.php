<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use function App\search;

class SearchEngineTest extends TestCase
{
    private array $docs;

    protected function setUp(): void
    {
        $garbage_patch_ocean_clean = "At the time of sampling, there were more than 1.8 trillion pieces of plastic in the patch that weigh an estimated 80,000 tonnes. These figures are much higher than previous calculations.

        TOTAL MASS AND COUNT
        The mass of the plastic in the Great Pacific Garbage Patch (GPGP) was estimated to be approximately 80,000 tonnes, which is 4-16 times more than previous calculations. This weight is also equivalent to that of 500 Jumbo Jets.
        The center of the GPGP has the highest density and the further boundaries are the least dense. When quantifying the mass of the GPGP, the team chose to account only for the denser center area. If the less-dense outer region was also considered in the total estimate, the total mass would then be closer to 100,000 tonnes.
        A total of 1.8 trillion plastic pieces were estimated to be floating in the patch – a plastic count that is equivalent to 250 pieces of debris for every human in the world.
        
        Using a similar approach as they did when figuring the mass, the team chose to employ conservative estimations of the plastic count. While 1.8 trillion is a mid-range value for the total count, their calculations estimated that it may be range from 1.1 to up to 3.6 trillion pieces.
        CONCENTRATION
        Using data from multiple reconnaissance missions, a mass concentration model was produced to visualize the plastic distribution in the patch.
        
        The mass concentration model, pictured below, shows how the concentration levels gradually decrease by orders of magnitude towards the outside boundaries of the GPGP. The center concentration levels contain the highest density, reaching 100s of kg/km² while decreasing down to 10 kg/km² in the outermost region.
        
        These results prove that plastic pollution at sea, while densely distributed within the patch, is scattered and does not form a solid mass, thus demystifying the trash island concept.
        VERTICAL DISTRIBUTION
        The Ocean Cleanup measured the vertical distribution of plastic during six expeditions between 2013 to 2015. Results from these expeditions proved that the buoyant plastic mass is distributed within the top few meters of the ocean.,
        
        Factors such as wind speed, sea state, and plastic buoyancy will influence vertical mixing. However, buoyant plastic will eventually float back to the surface in calmer seas. Larger pieces were observed to resurface much more rapidly than smaller pieces.
        
        
        https://theoceancleanup.com/great-pacific-garbage-patch/";

        $garbage_patch_NG = "The Great Pacific Garbage Patch is a collection of marine debris in the North Pacific Ocean. Marine debris is litter that ends up in oceans, seas, and other large bodies of water. 

        The Great Pacific Garbage Patch, also known as the Pacific trash vortex, spans waters from the West Coast of North America to Japan. The patch is actually comprised of the Western Garbage Patch, located near Japan, and the Eastern Garbage Patch, located between the U.S. states of Hawaii and California. 
        
        These areas of spinning debris are linked together by the North Pacific Subtropical Convergence Zone, located a few hundred kilometers north of Hawaii. This convergence zone is where warm water from the South Pacific meets up with cooler water from the Arctic. The zone acts like a highway that moves debris from one patch to another. 
        
        The entire Great Pacific Garbage Patch is bounded by the North Pacific Subtropical Gyre.  The National Oceanic and Atmospheric Administration (NOAA) defines a gyre as a large system of swirling ocean currents. Increasingly, however, it also refers to the garbage patch as a vortex of plastic waste and debris broken down into small particles in the ocean.  The North Pacific Subtropical Gyre is formed by four currents rotating clockwise around an area of 20 million square kilometers (7.7 million square miles): the California current, the North Equatorial current, the Kuroshio current, and the North Pacific current.
        
        The area in the center of a gyre tends to be very calm and stable. The circular motion of the gyre draws debris into this stable center, where it becomes trapped. A plastic water bottle discarded off the coast of California, for instance, takes the California Current south toward Mexico. There, it may catch the North Equatorial Current, which crosses the vast Pacific. Near the coast of Japan, the bottle may travel north on the powerful Kuroshiro Current. Finally, the bottle travels westward on the North Pacific Current. The gently rolling vortexes of the Eastern and Western Garbage Patches gradually draw in the bottle.
        
        The amount of debris in the Great Pacific Garbage Patch accumulates because much of it is not biodegradable. Many plastics, for instance, do not wear down; they simply break into tinier and tinier pieces.
        
        For many people, the idea of a “garbage patch” conjures up images of an island of trash floating on the ocean. In reality, these patches are almost entirely made up of tiny bits of plastic, called microplastics. Microplastics can’t always be seen by the naked eye. Even satellite imagery doesn’t show a giant patch of garbage. The microplastics of the Great Pacific Garbage Patch can simply make the water look like a cloudy soup. This soup is intermixed with larger items, such as fishing gear and shoes. 
        
        The seafloor beneath the Great Pacific Garbage Patch may also be an underwater trash heap. Oceanographers and ecologists recently discovered that about 70% of marine debris actually sinks to the bottom of the ocean.
        
        While oceanographers and climatologists predicted the existence of the Great Pacific Garbage Patch, it was a racing boat captain by the name of Charles Moore who actually discovered the trash vortex. Moore was sailing from Hawaii to California after competing in a yachting race. Crossing the North Pacific Subtropical Gyre, Moore and his crew noticed millions of pieces of plastic surrounding his ship.
        
        https://www.nationalgeographic.org/encyclopedia/great-pacific-garbage-patch/";

        $garbage_patch_spam = "Hi!

        Welcome to My Mystery Island Blog
        
        Garbage Patch
        
        Save the WORLD!
        
        Garbage everywhere. Everyone is talking about garbage. Ghostbusters are now chasing garbage people come to their senses!
        The era of consumption will kill us. We are obsessed with the outer paraphernalia of prosperity. Murder, hunger, crime don't bother me. And what worries me is celebrities and scandals, a TV with 500 channels, whose name is on the tag of cowards.
        The world is about to go to the bottom, so it's time to spit on all those sofas, green upholstery.
        I believe to hell with perfection, to hell with prosperity. Don't give a damn about it all. It's time to evolve.
        People are slaves to their things. Your job is not yourself. So is your money in the bank. And your car. Your wallet. And your clothes. You're just a bunch of life's waste. We're just a bunch of singing and dancing feces. Eat the trash before it kills you!
        TRASH TRASH TRASH
        
        Buy new trash item on dot.tv.com
        
        CATS::
        Cats and kittens can be so cute! You can use these Japanese cat emoticons for almost any occasion, like texting to friends or a significant other. Don’t you love being able to express yourself in so many different ways? Using these text emojis can really add a second dimension to what you’re trying to convey online.
        Cat smileys are probably some of the oldest emoticons in internet history. The original cat kaomoji looked like this =^_^= and =(^_^)= with = being the whiskers ^ the happy eyes (some people may read this as ears!) and _ the mouth. Now with an ever increasing assortment of unicode characters available, cat emoticons can take on all sorts of exciting and unique expressions!
        You can’t go wrong with these! By the way, ᨐ can be read as cat ears with two eyes.";

        $garbage_patch_wiki = 'The Great Pacific garbage patch, also described as the Pacific trash vortex, is a gyre of marine debris particles in the central North Pacific Ocean. It is located roughly from 135°W to 155°W and 35°N to 42°N. The collection of plastic and floating trash originates from the Pacific Rim, including countries in Asia, North America, and South America. The gyre is divided into two areas, the "Eastern Garbage Patch" between Hawaii and California, and the "Western Garbage Patch" extending eastward from Japan to the Hawaiian Islands.

        An ocean current about 6,000 miles long, referred to as the Subtropical Convergence Zone, connects the two patches, which extend over an indeterminate area of the widely varying range, depending on the degree of plastic concentration used to define the affected area. The vortex is characterized by exceptionally high relative pelagic concentrations of plastic, chemical sludge, wood pulp, and other debris trapped by the currents of the North Pacific Gyre. It is estimated that 1.15 to 2.41 million tonnes of plastic are entering the ocean each year from rivers. More than half of this plastic is less dense than the water, meaning that it will not sink once it encounters the sea.
        
        Despite the common public perception of the patch existing as giant islands of floating garbage, its low density (4 particles per cubic meter) prevents detection by satellite imagery, or even by casual boaters or divers in the area. This is because the patch is a widely dispersed area consisting primarily of suspended "fingernail-sized or smaller bits of plastic", often microscopic, particles in the upper water column known as microplastics.
        
        Researchers from The Ocean Cleanup project claimed that the patch covers 1.6 million square kilometers. The plastic concentration is estimated to be up to 100 kilograms per square kilometer in the center, going down to 10 kilograms per square kilometer in the outer parts of the patch. An estimated 87,000 metric tons of plastic inhabit the patch, totaling 1.8 trillion pieces. 92% of the mass in the patch comes from objects larger than 0.5 centimeters, while 94% of the total objects are represented by microplastics. Some of the plastic in the patch is over 50 years old, and includes items (and fragments of items) such as "plastic lighters, toothbrushes, water bottles, pens, baby bottles, cell phones, plastic bags, and nurdles."
        
        It is estimated that approximately "100 million tons of plastic are generated [globally] each year", and about 10% of that plastic ends up in the oceans. The United Nations Environmental Program recently estimated that "for every square mile of ocean" there are about "46,000 pieces of plastic." The small fibers of wood pulp found throughout the patch are "believed to originate from the thousands of tons of toilet paper flushed into the oceans daily." The patch is believed to have increased "10-fold each decade" since 1945.
        
        Research indicates that the patch is rapidly accumulating. A similar patch of floating plastic debris is found in the Atlantic Ocean, called the North Atlantic garbage patch.
        
        https://en.wikipedia.org/wiki/Great_Pacific_garbage_patch';

        $this->docs = [
            ['id' => 'garbage_patch_ocean_clean', 'text' => $garbage_patch_ocean_clean],
            ['id' => 'garbage_patch_NG', 'text' => $garbage_patch_NG],
            ['id' => 'garbage_patch_spam', 'text' => $garbage_patch_spam],
            ['id' => 'garbage_patch_wiki', 'text' => $garbage_patch_wiki],
        ];
    }

    public function testSimpleSearch(): void
    {
        $expected = ['doc2', 'doc1',];

        $this->assertEquals($expected, search($this->docs, 'garbage'));
    }

    // public function testTermSearch(): void
    // {
    //     $expected = ['doc2', 'doc1',];

    //     $this->assertEquals($expected, search($this->docs, '"shoot!'));
    // }

    // public function testFuzzySearch(): void
    // {
    //     $expected = ['doc2', 'doc1',];

    //     $this->assertEquals($expected, search($this->docs, 'shoot at me'));

    //     $expected = ['doc2', 'doc1', 'doc3',];

    //     $this->assertEquals($expected, search($this->docs, 'shoot I'));
    // }
}
