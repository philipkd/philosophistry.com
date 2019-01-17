#!/usr/bin/perl

# This is a small port I did from a php script I found.
# It worked on the few values I fed it to test it out
# but beware bugs may live here.  Email me if you find
# something, james at jamesmarch.com.

my ($red, $green, $blue) = HSBtoRGB(60,65,94);

print "Content-type: application/x-httpd-php\n\n";

for (my $i=0; $i < 10; $i++) {
#	my ($red, $green, $blue) = HSBtoRGB(60,100,100);
#	my ($red, $green, $blue) = HSBtoRGB(60,0,90);
	my ($red, $green, $blue) = HSBtoRGB(60,($i+1)*10,50+($i+1)*5);
	print "<state id=\"range\">\n\t<data>" . $i*10 . ' - ' . ($i+1)*10 . "</data>\n\t<color>" .  tuple2hex($red,$green,$blue) . "</color>\n</state>\n";
}



sub HSBtoRGB {
    my ($h, $s, $v) = @_;
    my $rgb = [];
    my @rgb_dec;
    $h = $h/60;
    $s = $s/100;
    $v = $v/100;
    if ($s == 0) {
        $rgb->[0] = $v*255;
        $rgb->[1] = $v*255;
        $rgb->[2] = $v*255;
    } else {
        my $i = int($h);
        my $p = $v * (1 - $s);
        my $q = $v * (1 - $s * ($h - $i));
        my $t = $v * (1 - $s * (1 - ($h - $i)));
        if ($i == 0) {
            $rgb_dec[0] = $v;
            $rgb_dec[1] = $t;
            $rgb_dec[2] = $p;
        } elsif ($i == 1) {
            $rgb_dec[0] = $q;
            $rgb_dec[1] = $v;
            $rgb_dec[2] = $p;
        } elsif ($i == 2) {
            $rgb_dec[0] = $p;
            $rgb_dec[1] = $v;
            $rgb_dec[2] = $t;
        } elsif ($i == 3) {
            $rgb_dec[0] = $p;
            $rgb_dec[1] = $q;
            $rgb_dec[2] = $v;
        } elsif ($i == 4) {
            $rgb_dec[0] = $t;
            $rgb_dec[1] = $p;
            $rgb_dec[2] = $v;
        } elsif ($i == 5) {
            $rgb_dec[0] = $v;
            $rgb_dec[1] = $p;
            $rgb_dec[2] = $q;
        } elsif ($i == 6) {
            $rgb_dec[0] = $v;
            $rgb_dec[1] = $p;
            $rgb_dec[2] = $q;
        }

        $rgb->[0]  = sprintf("%1.0f", $rgb_dec[0] * 255);
        $rgb->[1]  = sprintf("%1.0f", $rgb_dec[1] * 255);
        $rgb->[2]  = sprintf("%1.0f", $rgb_dec[2] * 255);
    }
    return @$rgb;
}

sub tuple2hex {
  my ($red, $green, $blue) = @_;
  my $rgb = sprintf "%.2x%.2x%.2x", $red, $green, $blue;
  return $rgb;
}
