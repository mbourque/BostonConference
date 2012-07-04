var wysihtml5ParserRules = {
  tags: {
    h3: {},
    h4: {},
    strong: {},
    b: {},
    i: {},
    em: {},
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
