<?php

/**
 * @var $mysqli
 */
include '../backend/bootstrap.php';

$citates = [
    'For the present is the only thing of which a man can be
deprived, if it is true that this is the only thing which he has, and
that a man cannot lose a thing if he has it not.',
    'Being thankful that he has been blessed in so many ways, he should do all in
his power to enlighten his less favored fellow, rather than be angry with
him on account of his misfortune. Is he not sufficiently punished in
being denied the light?',
    'I have often wondered, he says, how it is that every man loves
himself more than all the rest of men, and yet sets less value on his own
opinion of himself than on the opinion of others.',
    'And the things which conduce in any way to the commodity of life, and of
which fortune gives an abundant supply, he used without arrogance and
without excusing himself; so that when he had them, he enjoyed them
without affectation, and when he had them not, he did not want them.',
    'Labor not unwillingly, nor without regard to the common interest, nor
without due consideration, nor with distraction; nor let studied ornament
set off thy thoughts, and be not either a man of many words, or busy
about too many things',
    'Be cheerful also,
and seek not external help nor the tranquillity which others give. A man
then must stand erect, not be kept erect by others.',
    'Bear in mind that every man lives only this present time, which
is an indivisible point, and that all the rest of his life is either past
or it is uncertain.',
    'How much trouble he avoids who does not look to see what his neighbor
says or does or thinks, but only to what he does himself, that it may be
just and pure',
    'Be not disgusted, nor discouraged, nor dissatisfied, if thou dost not
succeed in doing everything according to right principles, but when thou
hast failed, return back again',
    'If any man is able to convince me and show me that I do not think or
act rightly, I will gladly change; for I seek the truth, by which no man
was ever injured. But he is injured who abides in his error and
ignorance.',
    'The best way of avenging thyself is not to become like [the wrong-
doer].',
    'Every man is worth just so much as the
things are worth about which he busies himself.',
    'It is in thy power to live free from all compulsion in the greatest
tranquillity of mind, even if all the world cry out against thee as much
as they choose, and even if wild beasts tear in pieces the members of
this kneaded matter which has grown around thee',
    'If thou art pained by any external thing, it is not this thing that
disturbs thee, but thy own judgment about it.',
    'A cucumber is bitter—Throw it away. —There are briers in the road—
Turn aside from them. —This is enough. Do not add, And why were such
things made in the world?',
    'Direct thy will to one thing only.',
    'But thou must
equally avoid flattering men and being vexed at them, for both are
unsocial and lead to harm.',
    'Consider that everything is opinion, and opinion is in thy power.
Take away then, when thou choosest, thy opinion, and like a mariner who
has doubled the promontory, thou wilt find calm, everything stable, and a
waveless bay.',
];

$random_citate = $citates[array_rand($citates)] . ' — Marcus Aurelius';

$tweet_service = new \App\Services\TweetService($mysqli);
$tweet_service->tweet($random_citate);


