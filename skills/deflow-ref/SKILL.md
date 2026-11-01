---
name: deflow-ref
description: "Tools for building from reference sites: a Playwright crawler, ATM (Amati, Tiru, Modifikasi) snapshot and compare scripts, design tokens with a CSS and Tailwind generator, a library shortlist, build-quality tells, and an Awwwards-style self-score. Use when a project has reference sites or needs tokens. Load with weave-core and weave-ui."
---

# deflow-ref

The design judgment lives in weave-ui; this skill holds the tools and procedures around it. The scripts need Playwright in the project: `npm i -D playwright && npx playwright install chromium`.

## Reference Sites and ATM

Crawl reference sites with `scripts/crawl-reference.mjs`; learn by rebuilding through ATM (`scripts/snapshot-site.mjs`, `scripts/compare-build.mjs`). Read `references/reference-sites.md` (it also lists galleries for finding references) and `references/atm.md` first. Always:

- Study the reference's decisions and reasons, then decide anew from this project's concept; never inherit its fonts, palette, layout, signature moment, or slop flags (R-40).
- Crawler numbers are lab values; rerun when a report warns that stylesheets or fonts failed (C-6).
- `atm/` and `reference-crawl/` stay local and never ship; nothing ships until `compare-build.mjs --mode modifikasi` passes; never snapshot behind a login or paywall (R-43).

## Tokens and Libraries

- Write the project's tokens as described in `references/design-tokens.md`, then generate CSS or a Tailwind `@theme` with `scripts/build-tokens.mjs`. The Tailwind output resets the default scales so only project utilities exist. Never retype a token value by hand.
- Pick libraries after the concept from `references/libraries.md`: one per job, native first, with reduced-motion paths and cleanup on navigation (R-41).

## The Bar and How It Is Scored

For landing pages and portfolios aiming at award-level craft: Awwwards scores Design 40%, Usability 30%, Creativity 20%, Content 10%. Effects do not move the score; a concept carried through the page does, and a slow or inaccessible site loses more than a beautiful one gains. Jury process and self-score: `references/awwwards-rubric.md`. Performance, mobile, keyboard, consistency, and content tells: `references/build-quality.md`.

## Ref Skill Checklist

Run these alongside the Delivery Gate in `weave-core` and the weave-ui checklist. Every line below must be true:

- [ ] References were studied for decisions, not copied; any ATM build passes `compare-build.mjs --mode modifikasi` (R-40, R-43)
- [ ] `atm/` and `reference-crawl/` are not committed (R-43)
- [ ] Tokens live in one file and CSS is generated from it, not retyped (R-40)
- [ ] One library per job, native first, each with a reduced-motion path (R-41)
- [ ] Core Web Vitals measured in a real browser on a throttled phone, not estimated (C-6)
- [ ] For award-level work, the rubric self-score is written down with its evidence (R-17)
