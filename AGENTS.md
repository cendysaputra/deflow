# AGENTS.md

Instructions for AI agents working on this repository: the deflow skills for running web projects. The writing and design rules they cite (R-XX, C-X) live in `weave-core`, in [agentic-weave](https://github.com/cendysaputra/agentic-weave).

## Commands

- `WEAVE_CORE=../agentic-weave/skills/weave-core/SKILL.md npm test`: lint every skill and check that each cited rule exists in `weave-core`. Without `WEAVE_CORE`, rule IDs are not checked. It must pass before every commit.
- `node skills/deflow/scripts/flow.mjs status`: run inside a project to see its gates.
- `claude plugin validate .`: check `.claude-plugin/` when it changes.
- Scripts in `skills/deflow-ref/scripts/` need Playwright: `npm i -D playwright && npx playwright install chromium`.

## Repository map

- `skills/deflow/`: the gated project flow. State lives in a project's `.deflow/`; `scripts/flow.mjs` checks each gate; templates are in `assets/`.
- `skills/deflow-convert/`: static build to WordPress, Elementor V4, WooCommerce, Statamic, Laravel, Astro, or React.
- `skills/deflow-ref/`: reference crawler, ATM scripts, design tokens and their generator, library shortlist, build-quality tells, Awwwards rubric.
- `scripts/lint-skills.mjs`: repo tooling, not part of any skill.

## Writing a skill

- Follow the skill rules in agentic-weave's AGENTS.md: `name` and `description` only, description under 350 characters, body under 500 lines and about 5,000 tokens, no intro boilerplate, **Tell** / **Why** / **Fix** / **Rule** entries, a closing checklist.
- The description ends with `Load with weave-core` plus the other skills it needs. Never copy rules from `weave-core`; cite them by ID so they live in one place. A new rule goes into `weave-core` in agentic-weave first.
- Refer to another skill by name, never by a `../` path.
- Mark anything not verified against a primary source, with the verification date next to versions and tool behavior.

## Git

- Commit subjects use Conventional Commits and name the change (load `weave-commit`).
- Never commit `atm/` or `reference-crawl/`. They hold third-party copies.
