import requests
import json

API_URL = "https://raw.githubusercontent.com/abusaeeidx/Toffee-playlist/refs/heads/main/script_api/data.json"
OUTPUT_FILE = "toffee.m3u"

def main():
    r = requests.get(API_URL)
    channels = r.json()

    with open(OUTPUT_FILE, "w", encoding="utf-8") as f:
        f.write("#EXTM3U\n")
        for ch in channels:
            link = f"https://www.xfireflix.fun/test/live.php?id={ch['id']}&e=.m3u8"
            f.write(f'#EXTINF:-1 tvg-id="{ch["id"]}" tvg-logo="{ch["logo"]}" group-title="Toffee", {ch["name"]}\n{link}\n\n')

    print(f"✅ Playlist generated: {OUTPUT_FILE}")

if __name__ == "__main__":
    main()