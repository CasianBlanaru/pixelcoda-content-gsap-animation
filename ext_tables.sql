#
# Modifying tt_content table
#
CREATE TABLE tt_content (
  tx_content_gsap_animation_animation tinytext,
  tx_content_gsap_animation_duration int(11) DEFAULT 800,
  tx_content_gsap_animation_delay int(11) DEFAULT 0,

  tx_content_gsap_animation_offset int(11) DEFAULT 0,
  tx_content_gsap_animation_once tinyint DEFAULT 1,
  tx_content_gsap_animation_mirror tinyint DEFAULT 0,
  tx_content_gsap_animation_easing tinytext,
  tx_content_gsap_animation_anchor_placement tinytext
);
