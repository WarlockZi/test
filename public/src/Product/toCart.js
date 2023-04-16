const lazyInit = (fn) => {
  let prom = undefined;
  return () => prom = (prom || fn());
}

export default function getVersion() {

  lazyInit(async () => {
    const programVersion = await version();

    return programVersion;
  });
}

