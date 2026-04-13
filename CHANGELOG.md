# Changelog (developers)

This file summarizes **internal and test-facing** changes compared to the **previous beta** of this library. The **JSON wire format** for integrators is unchanged (same `command` / `data` keys: `input`, `relay`, `relayGroup`).

## 1.5.0 (Release_1.5.0)

### Behaviour / validation

- **Multi-module requests:** relay and input index validation uses **`module.type` from the JSON request** for each `modules[]` entry (not a single default module type from config). Aligns validation with the documented contract.
- **`RelayControlDataFactory`:** removed **`validateRelay()`** that compared relay numbers against the **default** module type’s relay count (it broke console/feature tests and was wrong when the request carried another `module.type`).

### Structure (API surface for PHP consumers unchanged where documented)

- Introduced **`CommandDataRootKey`** enum for repeated `command.data` JSON key strings.
- **`ModuleCommandRegistry`:** centralized mapping from **surface** (e.g. `UNIVERSAL_SURFACE_TO_WIRE_ROWS`) to **wire** command names; reduced duplication in `ModuleCommandFactories`.
- **Command data factories** validate scalar/array shape; value objects **`Relay`**, **`Input`**, **`RelayGroup`** use **`fromArray()`** and **private constructors** so construction goes through validated paths.

### Tooling / repo hygiene

- **`composer.json`:** removed broken **`scripts`** entries; dropped **phpstan**, **psalm**, and **phpmd** from `require-dev` (they were not wired in CI here).
- **`README.md`:** fixed install snippet typo **`chmode` → `chmod`**; user note for 1.5.0 on multi-module validation.

### Tests

- **`ApiConsoleCommandTest`** and **`CliConsoleCommandTest`:** replaced empty stubs with assertions that commands run and exit successfully.
