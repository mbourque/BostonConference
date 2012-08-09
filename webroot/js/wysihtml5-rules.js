var wysihtml5ParserRules = {
  tags: {
    h3: {},
    h4: {},
    strong: {},
    b: {},
    i: {},
    em: {},
    img: {
        check_attributes: {
            width: "numbers",
            alt: "alt",
            src: "src",
            height: "numbers"
        },
        add_class: {
          align: "align_img"
        }
    },
    table: {},
    tbody: {},
    thead: {},
    th: {},
    style: {},
    tr: {},
    td: {},
    br: {},
    p: {},
    div: {},
    span: {},
    ul: {},
    ol: {},
    li: {},
    a: {
      set_attributes: {
      },
      check_attributes: {
        href: "url" // important to avoid XSS
      }
    }
  }
};
